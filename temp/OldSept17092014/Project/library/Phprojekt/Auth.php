<?php
/**
 * Auth class.
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
 * @package    Phprojekt
 * @subpackage Auth
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Eduardo Polidor <polidor@mayflower.de>
 */

/**
 * Auth class.
 *
 * @category   PHProjekt
 * @package    Phprojekt
 * @subpackage Auth
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Eduardo Polidor <polidor@mayflower.de>
 */
class Phprojekt_Auth extends Zend_Auth
{
    /**
     * Prefix for use in cookies.
     */
    const COOKIES_PREFIX = 'p6.';

    /**
     * Token.
     */
    const LOGGED_TOKEN = 'keepLoggedToken';

    /**
     * Checks in the session if user is loggued in or not.
     * If it is not logged, tries to log him/her using browser cookies.
     *
     * @throws Phprojekt_Auth_UserNotLoggedInException On user not logged in.
     *
     * @return boolean True if user is logued in.
     */
    static public function isLoggedIn()
    {
        $authNamespace = new Zend_Session_Namespace('Phprojekt_Auth-login');

        // Is there session data?
        if (!isset($authNamespace->userId) || empty($authNamespace->userId)) {
            // No - Read cookies
            $readingPrefix  = str_replace('.', '_', self::COOKIES_PREFIX);
            $cookieHashName = $readingPrefix . self::LOGGED_TOKEN . '_hash';
            $cookieUserId   = $readingPrefix . self::LOGGED_TOKEN . '_user';
            // Are there cookies?
            if (isset($_COOKIE[$cookieHashName]) && isset($_COOKIE[$cookieUserId])
                && (int) $_COOKIE[$cookieUserId] > 0) {
                // Yes
                $tokenCookieHash   = Cleaner::sanitize('alnum', $_COOKIE[$cookieHashName]);
                $tokenCookieUserId = (int) $_COOKIE[$cookieUserId];
                $goToLoginPage     = false;
                $setting           = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
                $setting->setModule('User');
                $tokenDbHash    = $setting->getSetting(self::LOGGED_TOKEN . '_hash', $tokenCookieUserId);
                $tokenDbExpires = (int) $setting->getSetting(self::LOGGED_TOKEN . '_expires', (int) $tokenCookieUserId);

                // Is there valid DB token data, which has not expired?
                if ($tokenDbExpires > time()) {
                    // Yes - The expiration time exists and is valid. The hashes match?
                    if ($tokenCookieHash == $tokenDbHash) {
                        // Yes - Log in the user
                        $user = Phprojekt_Loader::getLibraryClass('Phprojekt_User_User');
                        $user->find($tokenCookieUserId);
                        // If the user was found we will save the user information in the session
                        $authNamespace->userId = $user->id;
                        $authNamespace->admin  = $user->admin;

                        // Save the data into the DB and Cookies
                        self::_saveLoginData($tokenCookieUserId);
                    } else {
                        $goToLoginPage = true;
                    }
                } else {
                    $goToLoginPage = true;
                }

                if ($goToLoginPage) {
                    self::_deleteDbAndCookies($tokenCookieUserId);
                    throw new Phprojekt_Auth_UserNotLoggedInException('User not logged in', 1);
                }
            } else {
                throw new Phprojekt_Auth_UserNotLoggedInException('User not logged in', 1);
            }
        }

        return true;
    }

    /**
     * Makes the login process.
     *
     * @param string  $username   Username provided.
     * @param string  $password   Clean password typed by user.
     * @param boolean $keepLogged Keep the user logued for next uses.
     *
     * @throws Phprojekt_Auth_Exception On login errors.
     *
     * @return boolean True if login process was sucessful.
     */
    public static function login($username, $password, $keepLogged = false)
    {
        $user   = Phprojekt_Loader::getLibraryClass('Phprojekt_User_User');
        $userId = $user->findIdByUsername($username);

        if ($userId > 0) {
            $user->find($userId);
        } else {
            throw new Phprojekt_Auth_Exception('Invalid user or password', 4);
        }

        if (!$user->isActive()) {
            throw new Phprojekt_Auth_Exception('User Inactive', 5);
        }

        try {
            $setting = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
            $setting->setModule('User');

            // The password does not match with password provided
            if (!Phprojekt_Auth::_compareStringWithPassword($password, $setting->getSetting("password", $userId))) {
                throw new Phprojekt_Auth_Exception('Invalid user or password', 2);
            }
        } catch (Exception $error) {
            $error->getMessage();
            throw new Phprojekt_Auth_Exception('Invalid user or password', 3);
        }

        // Regenerate the id if we are not in the unitTest
        if (!headers_sent()) {
            Zend_Session::regenerateId();
        }

        // If the user was found we will save the user information on the session
        $authNamespace = new Zend_Session_Namespace('Phprojekt_Auth-login');
        $authNamespace->userId = $user->id;
        $authNamespace->admin  = $user->admin;

        if ($keepLogged) {
            // Delete previous existing data, just in case
            self::_deleteDbAndCookies($userId);
            // Store matching keepLogged data in DB and browser
            self::_saveLoginData($userId);
        }

        // Please, put any extra info of user to be saved on session here
        return true;
    }

    /**
     * Gets from auth namespace the user ID logged in.
     *
     * @return integer|false user ID or false if there isn't user logged.
     */
    static public function getUserId()
    {
        $returnValue   = 0;
        $authNamespace = new Zend_Session_Namespace('Phprojekt_Auth-login');

        if (isset($authNamespace->userId)) {
            $returnValue = $authNamespace->userId;
        }

        return (int) $returnValue;
    }

    /**
     * Gets from auth namespace if the user is admin or not.
     *
     * @return integer 1 or 0.
     */
    public static function isAdminUser()
    {
        $returnValue   = 0;
        $authNamespace = new Zend_Session_Namespace('Phprojekt_Auth-login');

        if (isset($authNamespace->admin)) {
            $returnValue = $authNamespace->admin;
        }

        return $returnValue;
    }

    /**
     * Makes the logout process.
     *
     * @return boolean True if logout process was sucessful.
     */
    public static function logout()
    {
        $userId        = 0;
        $authNamespace = new Zend_Session_Namespace('Phprojekt_Auth-login');
        // Try to read user id from PHP session
        if (isset($authNamespace->userId) && !empty($authNamespace->userId)) {
            $userId = $authNamespace->userId;
        } else {
            // Try to read user id from cookies
            $readingPrefix = str_replace('.', '_', self::COOKIES_PREFIX);
            $cookieUserId  = $readingPrefix . self::LOGGED_TOKEN . '_user';
            if (isset($_COOKIE[$cookieUserId])) {
                $userId = (int) $_COOKIE[$cookieUserId];
            }
        }

        self::_deleteDbAndCookies($userId);
        Zend_Session::destroy();
        return true;
    }

    /**
     * Compare a string with a user password.
     *
     * @param string $string   Key uncryted to check if it is the password.
     * @param string $password Crypted password.
     *
     * @return boolean True if the string crypted is equal to provide password.
     */
    private static function _compareStringWithPassword($string, $password)
    {
        // One of the methods to check the password
        $defaultMethod = 'phprojektmd5' . (string) $string;
        $defaultMethod = Phprojekt_Auth::_cryptPassword($defaultMethod);

        if ($defaultMethod == (string) $password) {
            return true;
        }

        // Please add other valid methods here (e.g. not crypted password)
        // None of the methods works
        return false;
    }

    /**
     * String to be crytped.
     *
     * @param string $password String to be cripted.
     *
     * @return scring Crypted password.
     */
    private static function _cryptPassword($password)
    {
        return md5($password);
    }

    /**
     * String to be crytped.
     *
     * @param string $string String to be cripted.
     *
     * @return scring Crypted password.
     */
    public static function cryptString($string)
    {
        $cryptedString = 'phprojektmd5' . $string;

        return Phprojekt_Auth::_cryptPassword($cryptedString);
    }

    /**
     * Deletes login data on DB and cookies.
     *
     * @param integer $userId ID of the user.
     *
     * @return void
     */
    private static function _deleteDbAndCookies($userId)
    {
        if ($userId) {
            // Delete all DB settings table token rows
            $db      = Phprojekt::getInstance()->getDb();
            $setting = Phprojekt_Loader::getLibraryClass('Phprojekt_Setting');
            $setting->setModule('User');
            $where = sprintf("user_id = %d AND key_value LIKE %s", (int) $userId, $db->quote(self::LOGGED_TOKEN . '%'));
            $rows  = $setting->fetchAll($where);
            foreach ($rows as $row) {
                $row->delete();
            }
        }

        // Don't work with cookies if headers have already been sent (when unittest are being executed)
        if (headers_sent()) {
            return;
        }

        self::_setCookies("", 0, 1);
    }

    /**
     * Save the login data into Settings and Cookies.
     *
     * @param integer $userId Current user ID.
     *
     * @return void
     */
    private static function _saveLoginData($userId)
    {
        // The hash string is changed everytime it is used, and the expiration time updated.
        // DB Settings table: create new md5 hash and update expiration time for it

        // Set the settings pair to save
        $pair = array(self::LOGGED_TOKEN . '_hash'    => md5(time() . mt_rand()),
                      self::LOGGED_TOKEN . '_expires' => strtotime('+1 week'));

        // Store matching keepLogged data in DB and browser
        $user = Phprojekt_Loader::getLibraryClass('Phprojekt_User_User');
        $user->find($userId);
        $settings = $user->settings->fetchAll();

        foreach($pair as $key => $value) {
            $found = false;
            foreach ($settings as $setting) {
                // Update
                if ($setting->keyValue == $key) {
                    $setting->value = $value;
                    $setting->save();
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // Create
                $record             = $user->settings->create();
                $record->moduleId   = 0;
                $record->keyValue   = $key;
                $record->value      = $value;
                $record->identifier = 'Login';
                $record->save();
            }
        }

        // Cookies: update md5 hash and expiration time
        // If we are under Unittest execution, don't work with cookies:
        if (!headers_sent()) {
            self::_setCookies($pair[self::LOGGED_TOKEN . '_hash'], $userId, $pair[self::LOGGED_TOKEN . '_expires']);
        }
    }

    /**
     * Set the cookies.
     *
     * @param string  $hash    User hash for check.
     * @param integer $userId  Current userId.
     * @param integer $expires Timestamp for expire.
     *
     * @return void
     */
    private static function _setCookies($hash, $userId, $expires)
    {
        // Set cookies
        $completePath     = Phprojekt::getInstance()->getConfig()->webpath;
        $partialPathBegin = strpos($completePath, "/", 8);
        $partialPath      = substr($completePath, $partialPathBegin);
        $cookieHash       = self::COOKIES_PREFIX . self::LOGGED_TOKEN . '.hash';
        $cookieUser       = self::COOKIES_PREFIX . self::LOGGED_TOKEN . '.user';
        setcookie($cookieHash, $hash, $expires, $partialPath);
        setcookie($cookieUser, $userId, $expires, $partialPath);
    }
}
