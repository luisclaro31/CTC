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
 * @subpackage Core
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @version    Release: @package_version@
 * @author     Gustavo Solt <solt@mayflower.de>
 */

dojo.provide("phpr.Core.Form");

dojo.declare("phpr.Core.Form", phpr.Default.Form, {
    setUrl:function() {
        // Summary:
        //    Rewritten the function for work like a system module and like a form
        // Description:
        //    Rewritten the function for work like a system module and like a form
        if (this.main.isSystemModule(this.main.module)) {
            this._url = phpr.webpath + 'index.php/Core/' + phpr.module.toLowerCase() + '/jsonDetail/nodeId/1/id/'
                + this.id;
        } else {
            this._url = phpr.webpath + 'index.php/Core/' + phpr.module.toLowerCase() + '/jsonDetail/nodeId/1/'
                + 'moduleName/' + phpr.submodule;
        }
    },

    initData:function() {
    },

    setPermissions:function(data) {
        this._writePermissions  = true;
        this._deletePermissions = false;
        if (this.id > 0) {
            this._deletePermissions = true;
        }
        this._accessPermissions = true;
    },

    addBasicFields:function() {
    },

    addModuleTabs:function(data) {
    },

    useCache:function() {
        if (this.main.isSystemModule(this.main.module)) {
            return true;
        } else {
            return false;
        }
    },

    submitForm:function() {
        // Summary:
        //    Rewritten the function for work like a system module and like a form
        // Description:
        //    Rewritten the function for work like a system module and like a form
        if (!this.prepareSubmission()) {
            return false;
        }
        if (this.main.isSystemModule(this.main.module)) {
            var url = phpr.webpath + 'index.php/Core/' + phpr.module.toLowerCase() + '/jsonSave/nodeId/1/id/' + this.id;
        } else {
            var url = phpr.webpath + 'index.php/Core/' + phpr.module.toLowerCase() + '/jsonSave/nodeId/1/moduleName/'
                + phpr.submodule;
        }
        phpr.send({
            url:       url,
            content:   this.sendData,
            onSuccess: dojo.hitch(this, function(data) {
                new phpr.handleResponse('serverFeedback', data);
                if (data.type == 'success') {
                    this.customActionOnSuccess();
                    this.publish("updateCacheData");
                    if (this.main.isSystemModule(this.main.module)) {
                        this.publish("setUrlHash", [phpr.parentmodule, null, [phpr.module]]);
                    } else {
                        this.publish("setUrlHash", [phpr.parentmodule]);
                    }
                }
            })
        });
    },

    customActionOnSuccess:function() {
        // Summary:
        //    Function for be rewritten
        // Description:
        //    Function for be rewritten
    },

    deleteForm:function() {
        phpr.send({
            url:       phpr.webpath + 'index.php/Core/' + phpr.module.toLowerCase() + '/jsonDelete/id/' + this.id,
            onSuccess: dojo.hitch(this, function(data) {
                new phpr.handleResponse('serverFeedback', data);
                if (data.type == 'success') {
                    this.publish("updateCacheData");
                    this.publish("setUrlHash", [phpr.parentmodule, null, [phpr.module]]);
                }
            })
        });
    },

    updateData:function() {
        phpr.DataStore.deleteData({url: this._url});
    },

    setBreadCrumbItem:function(itemValue) {
        phpr.BreadCrumb.setItem(itemValue);
    }
});
