/**
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
 * @subpackage Project
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Gustavo Solt <solt@mayflower.de>
 */

dojo.provide("phpr.Project.FormBasicData");

dojo.declare("phpr.Project.FormBasicData", phpr.Project.Form, {
    setUrl:function() {
        // Summary:
        //    Set the url for get the data
        this._url = phpr.webpath + 'index.php/' + phpr.module + '/index/jsonDetail/nodeId/'
            + phpr.Tree.getParentId(this.id) + '/id/' + this.id;
    },

    initData:function() {
        // Get the rights for other users
        this._accessUrl = phpr.webpath + 'index.php/' + phpr.module + '/index/jsonGetUsersRights'
            + '/nodeId/' + phpr.Tree.getParentId(phpr.currentProjectId) + '/id/' + this.id;
        this._initData.push({'url': this._accessUrl});

        // Get all the active users
        this.userStore = new phpr.Store.User(phpr.Tree.getParentId(this.id));
        this._initData.push({'store': this.userStore});

        // Get roles
        this.roleStore = new phpr.Store.Role(phpr.Tree.getParentId(phpr.currentProjectId), this.id);
        this._initData.push({'store': this.roleStore});

        // Get modules
        this.moduleStore = new phpr.Store.Module(phpr.Tree.getParentId(phpr.currentProjectId), this.id);
        this._initData.push({'store': this.moduleStore});

        // Get the tags
        this._tagUrl  = phpr.webpath + 'index.php/Default/Tag/jsonGetTagsByModule/moduleName/' + phpr.module
            + '/id/' + this.id;
        this._initData.push({'url': this._tagUrl});
    },

    postRenderForm:function() {
        if (dijit.byId("deleteButton")) {
            dijit.byId("deleteButton").destroy();
        }
    },

    submitForm:function() {
        if (!this.prepareSubmission()) {
            return false;
        }

        phpr.send({
            url: phpr.webpath + 'index.php/' + phpr.module + '/index/jsonSave/nodeId/' + phpr.Tree.getParentId(this.id)
                + '/id/' + this.id,
            content:   this.sendData,
            onSuccess: dojo.hitch(this, function(data) {
               new phpr.handleResponse('serverFeedback', data);
               if (!this.id) {
                   this.id = data['id'];
               }
               if (data.type == 'success') {
                   phpr.send({
                        url: phpr.webpath + 'index.php/Default/Tag/jsonSaveTags/moduleName/' + phpr.module
                            + '/id/' + this.id,
                        content:   this.sendData,
                        onSuccess: dojo.hitch(this, function(data) {
                            if (this.sendData['string']) {
                                new phpr.handleResponse('serverFeedback', data);
                            }
                            if (data.type == 'success') {
                                this.publish("updateCacheData");
                                this.publish("changeProject", [this.id]);
                            }
                        })
                    });
                }
            })
        });
    }
});
