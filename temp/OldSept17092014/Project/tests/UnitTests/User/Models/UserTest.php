<?php
/**
 * Unit test
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
 * @package    UnitTests
 * @subpackage User
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     Eduardo Polidor <polidor@mayflower.de>
 */

require_once 'PHPUnit/Framework.php';

/**
 * Tests User Model class
 *
 * @category   PHProjekt
 * @package    UnitTests
 * @subpackage User
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     Eduardo Polidor <polidor@mayflower.de>
 * @group      user
 * @group      model
 * @group      user-model
 */
class User_User_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Test valid method
     */
    public function testSave()
    {
        $user = new Phprojekt_User_User();
        $user->find(3);
        $this->assertEquals($user->saveRights(), null);
        $this->assertEquals($user->recordValidate(), false);
        $error = $user->getError();
        $this->assertEquals('firstname', $error[0]['field']);
        $this->assertEquals('Is a required field', $error[0]['message']);
        $this->assertEquals('lastname', $error[1]['field']);
    }

    /**
     * Test save function
     */
    public function testUserNamecheck()
    {
        $user            = new Phprojekt_User_User();
        $user->username  = 'david';
        $user->firstname = 'testuser';
        $user->lastname  = 'testuser';
        $user->status    = 'A';
        $this->assertEquals(false, $user->recordValidate());
        $error = $user->getError();
        $this->assertEquals('Already exists, choose another one please', $error[0]['message']);
    }

    /**
     * Test save function
     */
    public function testUpdate()
    {
        $user = new Phprojekt_User_User();
        $user->username  = 'testuser';
        $user->username  = 'testuser';
        $user->firstname = 'testuser';
        $user->lastname  = 'testuser';
        $user->status    = 'A';
        $user->save();

        $user->username = 'testuserchanged';
        $user->save();
        $this->assertEquals('testuserchanged', $user->username);
    }

    /**
     * Test delete
     */
    public function testDelete()
    {
        $user = new Phprojekt_User_User();
        $user->find(1);
        $this->setExpectedException('Phprojekt_User_Exception');
        $user->delete();
    }

    /**
     * Test for mock function
     */
    public function testMocks()
    {
        $user = new Phprojekt_User_User();
        $this->assertEquals(array(), $user->getRights());
    }

    /**
     * Test the display
     */
    public function testdisplay()
    {
        $user = new Phprojekt_User_User();
        $this->assertEquals(array('lastname', 'firstname'), $user->getDisplay());

        $user->find(2);
        $this->assertEquals('Solt, Gustavo', $user->applyDisplay(array('lastname', 'firstname'), $user));
        $this->assertEquals('gus, Solt, Gustavo', $user->applyDisplay(array('username', 'lastname', 'firstname'),
            $user));
        $this->assertEquals('gus', $user->applyDisplay(array('username'), $user));
    }
}
