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
 * @subpackage Phprojekt
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     Gustavo Solt <solt@mayflower.de>
 */

require_once 'PHPUnit/Framework.php';

/**
 * Tests History
 *
 * @category   PHProjekt
 * @package    UnitTests
 * @subpackage Phprojekt
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     Gustavo Solt <solt@mayflower.de>
 * @group      phprojekt
 * @group      history
 * @group      phprojekt-history
 */
class Phprojekt_HistoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test empty call
     */
    public function testEmptyObject()
    {
        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $this->setExpectedException('Exception');
        $history->saveFields('', 'add');
    }

    /**
     * Test add history
     */
    public function testAddCall()
    {
        $project = new Project_Models_Project(array('db' => $this->sharedFixture));

        $project->projectId = 2;
        $project->path = '/1/';
        $project->title = 'TEST';
        $project->startDate = '1981-05-12';
        $project->endDate = '1981-05-12';
        $project->priority = 1;
        $project->currentStatus = 2;
        $project->save();
        Zend_Registry::set('insertedId', $project->id);

        $history = new Phprojekt_History(array('db' => $this->sharedFixture));
        $data = $history->getHistoryData($project, $project->id);
        $array = array('userId'   => '1',
                       'moduleId' => '1',
                       'itemId'   => $project->id,
                       'field'    => 'currentStatus',
                       'label'    => 'Status',
                       'oldValue' => '',
                       'newValue' => 'Ordered',
                       'action'   => 'add',
                       'datetime' => date("Y-m-d"));
        $found = 0;
        foreach ($data as $values) {
            /* Remove the hour */
            $values['datetime'] = substr($values['datetime'], 0, 10);
            $result             = array_diff_assoc($values, $array);

            if (empty($result)) {
                $found = 1;
            }
        }
        if (!$found) {
            $this->fail('Save add history error');
        }
    }

    /**
     * Test edit history
     */
    public function testEditCall()
    {
        $project = new Project_Models_Project(array('db' => $this->sharedFixture));
        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $project->find(Zend_Registry::get('insertedId'));
        $project->title = 'EDITED TEST';
        $project->save();

        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $data = $history->getHistoryData($project, $project->id);
        $array = array('userId'   => '1',
                       'moduleId' => '1',
                       'itemId'   => Zend_Registry::get('insertedId'),
                       'field'    => 'title',
                       'label'    => 'Title',
                       'oldValue' => 'TEST',
                       'newValue' => 'EDITED TEST',
                       'action'   => 'edit',
                       'datetime' => date("Y-m-d"));
        $found = 0;
        foreach ($data as $values) {
            /* Remove the hour */
            $values['datetime'] = substr($values['datetime'], 0, 10);
            $result = array_diff_assoc($values, $array);

            if (empty($result)) {
                $found = 1;
            }
        }
        if (!$found) {
            $this->fail('Save edit history error');
        }
    }

    /**
     * Test get data
     */
    public function testGetHistoryData()
    {
        $project = new Project_Models_Project(array('db' => $this->sharedFixture));
        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $data  = $history->getHistoryData($project, Zend_Registry::get('insertedId'));
        $array = array('userId'   => '1',
                       'moduleId' => '1',
                       'itemId'   => Zend_Registry::get('insertedId'),
                       'field'    => 'title',
                       'label'    => 'Title',
                       'oldValue' => 'TEST',
                       'newValue' => 'EDITED TEST',
                       'action'   => 'edit',
                       'datetime' => date("Y-m-d"));
        $found = 0;
        foreach ($data as $values) {
            /* Remove the hour */
            $values['datetime'] = substr($values['datetime'], 0, 10);
            $result = array_diff_assoc($values, $array);

            if (empty($result)) {
                $found = 1;
            }
        }
        if (!$found) {
            $this->fail('Get history error');
        }
    }

    /**
     * Test get last data
     */
    public function testGetLastHistoryData()
    {
        $project = new Project_Models_Project(array('db' => $this->sharedFixture));
        $project->find(Zend_Registry::get('insertedId'));
        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $data     = $history->getHistoryData($project, Zend_Registry::get('insertedId'));
        $lastData = $history->getLastHistoryData($project);

        $this->assertEquals(7, count($data));
        $this->assertEquals(1, count($lastData));
    }

    /**
     * Test delete history
     */
    public function testDeleteCall()
    {
        $project = new Project_Models_Project(array('db' => $this->sharedFixture));
        $history = new Phprojekt_History(array('db' => $this->sharedFixture));

        $project->find(Zend_Registry::get('insertedId'));
        $project->delete();

        $data  = $history->getHistoryData($project, Zend_Registry::get('insertedId'));
        $array = array('userId'   => '1',
                       'moduleId' => '1',
                       'itemId'   => Zend_Registry::get('insertedId'),
                       'field'    => 'title',
                       'label'    => 'Title',
                       'oldValue' => 'EDITED TEST',
                       'newValue' => '',
                       'action'   => 'delete',
                       'datetime' => date("Y-m-d"));
        $found = 0;
        foreach ($data as $values) {
            /* Remove the hour */
            $values['datetime'] = substr($values['datetime'], 0, 10);
            $result = array_diff_assoc($values, $array);

            if (empty($result)) {
                $found = 1;
            }
        }
        if (!$found) {
            $this->fail('Save delete history error');
        }
    }
}
