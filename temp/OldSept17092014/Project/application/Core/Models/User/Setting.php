<?php
/**
 * Settings on a per user base.
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 3 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * @category   PHProjekt
 * @package    Application
 * @subpackage Core
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Gustavo Solt <solt@mayflower.de>
 */

/**
 * Settings on a per user base.
 *
 * @category   PHProjekt
 * @package    Application
 * @subpackage Core
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Gustavo Solt <solt@mayflower.de>
 */
class Core_Models_User_Setting extends Phprojekt_ModelInformation_Default
{
    /**
     * Range of dates language setting.
     *
     * @var array
     */
    private $_languageRange = array();

    /**
     * Range of available timezones.
     *
     * @var array
     */
    private $_timeZoneRange = array();

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_languageRange = Phprojekt_LanguageAdapter::getLanguageList();
        $this->_timeZoneRange = Phprojekt_Converter_Time::getTimeZones();
    }

    /**
     * Sets a fields definitions for each field.
     *
     * @return void
     */
    public function setFields()
    {
        // password
        $this->fillField('password', 'Password', 'password', 0, 1, array(
            'length' => 50));

        // confirmValue
        $this->fillField('confirmValue', 'Confirm Password', 'password', 0, 2, array(
            'length' => 50));

        // oldValue
        $this->fillField('oldValue', 'Old Password', 'password', 0, 3, array(
            'length' => 50));

        // email
        $this->fillField('email', 'Email', 'text', 0, 4, array(
            'length' => 255));

        // language
        $range = array();
        foreach ($this->_languageRange as $key => $value) {
            $range[] = $this->getRangeValues($key, $value);
        }
        $this->fillField('language', 'Language', 'selectbox', 0, 5, array(
            'range'    => $range,
            'required' => true,
            'default'  => 'en'));

        // timeZone
        $range = array();
        foreach ($this->_timeZoneRange as $key => $value) {
            $range[] = $this->getRangeValues($key, $value);
        }
        $this->fillField('timeZone', 'Time zone', 'selectbox', 0, 6, array(
            'range'    => $range,
            'required' => true,
            'default'  => '000'));
    }

    /**
     * Getter for password field.
     *
     * @return string Empty string.
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * Validate the settings.
     *
     * @param array $params Array with values to save.
     *
     * @return string|null Error message.
     */
    public function validateSettings($params)
    {
        $message = null;
        $setting = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
        $setting->setModule('User');

        // Passwords
        $confirmPassValue = (isset($params['confirmValue'])) ? $params['confirmValue'] : null;
        $oldPassValue     = (isset($params['oldValue'])) ? $params['oldValue'] : null;
        $newPassValue     = $params['password'];
        $currentPassValue = $setting->getSetting('password');

        if (isset($params['id']) && $params['id'] == 0 && empty($newPassValue)) {
            $message = Phprojekt::getInstance()->translate('Password') . ': '
                . Phprojekt::getInstance()->translate('Is a required field');
        } else if (!isset($params['id']) && ((!empty($newPassValue) && $newPassValue != $confirmPassValue)
            || (empty($newPassValue) && !empty($confirmPassValue)))) {
            $message = Phprojekt::getInstance()->translate('The password and confirmation are different or one of them '
                . 'is empty');
        } else if (!isset($params['id']) &&
            (!empty($newPassValue) && $currentPassValue != Phprojekt_Auth::cryptString($oldPassValue))) {
            $message = Phprojekt::getInstance()->translate('The old password provided is invalid');
        }

        // TimeZone
        if (!array_key_exists($params['timeZone'], $this->_timeZoneRange)) {
            $message = Phprojekt::getInstance()->translate('The Time zone value is out of range');
        }

        // Language
        if (!array_key_exists($params['language'], $this->_languageRange)) {
            $message = Phprojekt::getInstance()->translate('The Language value do not exists');
        }

        // Email
        if (!empty($params['email'])) {
            $validator = new Zend_Validate_EmailAddress();
            if (!$validator->isValid($params['email'])) {
                $message = Phprojekt::getInstance()->translate('Invalid email address');
            }
        }

        return $message;
    }

    /**
     * Save the settings into the table.
     *
     * @param array   $params $_POST fields.
     * @param integer $userId The user ID, if is not setted, the current user is used.
     *
     * @return void
     */
    public function setSettings($params, $userId = 0)
    {
        if (!$userId) {
            $userId = Phprojekt_Auth::getUserId();
        }
        $setting = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
        $setting->setModule('User');
        if (empty($params['password'])) {
            $password = $setting->getSetting('password', $userId);
        } else {
            $password = Phprojekt_Auth::cryptString($params['password']);
        }

        $namespace = new Zend_Session_Namespace(Phprojekt_Setting::IDENTIFIER, $userId);
        $fields    = $this->getFieldDefinition(Phprojekt_ModelInformation_Default::ORDERING_FORM);
        foreach ($fields as $data) {
            foreach ($params as $key => $value) {
                if ($key == $data['key'] && $key != 'oldValue' && $key != 'confirmValue') {
                    $setting = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
                    $setting->setModule('User');

                    if (($key == 'password')) {
                        $value = $password;
                    }

                    $where = sprintf('user_id = %d AND key_value = %s AND module_id = %d', (int) $userId,
                        $setting->_db->quote($key), 0);
                    $record = $setting->fetchAll($where);

                    if (isset($record[0])) {
                        $record[0]->keyValue = $key;
                        $record[0]->value    = $value;
                        $record[0]->save();
                    } else {
                        $setting->userId     = $userId;
                        $setting->moduleId   = 0;
                        $setting->keyValue   = $key;
                        $setting->value      = $value;
                        $setting->identifier = 'Core';
                        $setting->save();
                    }
                    $namespace->$key = $value;
                    break;
                }
            }
        }
    }
}
