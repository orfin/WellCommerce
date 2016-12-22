/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

var oDefaults = {
    oClasses: {}
};

var GFormNode = function (oOptions) {

    var gThis = this;

    gThis.m_jNode;
    gThis.m_gParent;
    gThis.m_gForm;
    gThis.m_sNamePrefix;
    gThis.m_bRepeatable;
    gThis.m_bIgnore = false;
    gThis.m_oInitializedDependencies = {};

    gThis._Constructor = function () {
    };

    gThis.Render = function () {
        gThis.m_bRepeatable = false;
        if ((gThis.m_oOptions.oRepeat != undefined) && (gThis.m_oOptions.oRepeat.iMax != undefined) && (gThis.m_oOptions.oRepeat.iMax > 1)) {
            gThis.m_bRepeatable = true;
        }
        gThis._PrepareNode();
        gThis.m_jNode.get(0).gNode = gThis;
        gThis.m_jNode.addClass('GFormNode');
        return gThis.m_jNode;
    };

    gThis._GetClass = function (sClassName) {
        var sClass = gThis.m_oOptions.oClasses['s' + sClassName + 'Class'];
        if (sClass == undefined) {
            return '';
        }
        else {
            return sClass;
        }
    };

    gThis._GetImage = function (sImageName) {
        var sImage = gThis.m_oOptions.oImages['s' + sImageName];
        if (sImage == undefined) {
            return '';
        }
        else {
            return GCore.DESIGN_PATH + sImage;
        }
    };

    gThis.GetName = function (sId) {
        if ((gThis.m_sNamePrefix == undefined) || (gThis.m_sNamePrefix == '')) {
            return (sId != undefined) ? gThis.m_oOptions.sName + '[' + sId + ']' : gThis.m_oOptions.sName;
        }
        var sName = gThis.m_sNamePrefix + '[' + gThis.m_oOptions.sName + ']';
        if (sId != undefined) {
            sName += '[' + sId + ']';
        }
        return sName;
    };

    gThis.GetId = function (sId) {
        var sName = gThis.GetName().replace(/[\[\]]+/g, '__').replace(/\_\_$/, '');
        if (sId != undefined) {
            sName += '__' + sId;
        }
        return sName;
    };

    gThis.Populate = function (mData) {
    };
    gThis.PopulateErrors = function (mData) {
    };
    gThis.Validate = function (bNoRequests, iRepetition) {
        return true;
    };

    gThis.OnInit = function () {
        gThis._Initialize();
        gThis._InitializeEvents();
        gThis._InitializeDependencies();
        gThis._InitializeRules();
    };

    gThis._InitializeDependencies = function () {
        if (gThis.m_oOptions.agDependencies != undefined) {
            for (var i in gThis.m_oOptions.agDependencies) {
                gThis.m_oOptions.agDependencies[i].Constructor(gThis.m_gForm, gThis.m_oOptions.sName);
            }
        }
    };

    gThis._InitializeRules = function () {
        if (!gThis.m_jNode) {
            return;
        }
        if (gThis.m_oOptions.aoRules != undefined) {
            for (var i = 0; i < gThis.m_oOptions.aoRules.length; i++) {
                if (gThis.m_oOptions.aoRules[i].sType == 'required') {
                    gThis.m_jNode.addClass('required');
                }
            }
        }
    };

    gThis.OnReset = function () {
    };
    gThis.OnShow = function () {
    };
    gThis.OnHide = function () {
    };
    gThis.OnRemove = function () {
    };
    gThis.Reset = function () {
    };
    gThis.Focus = function () {
        return false;
    };

    gThis.BindChangeHandler = function (fHandler, oData) {
        return gThis.m_jNode.bind('change', oData, fHandler);
    };

    gThis._PrepareNode = function () {
    };
    gThis._Initialize = function () {
    };
    gThis._InitializeEvents = function () {
    };

    gThis.Ignore = function () {
        gThis.m_bIgnore = true;
    };

    gThis.Unignore = function () {
        gThis.m_bIgnore = false;
    };

    gThis.Show = function () {
        gThis.Unignore();
        gThis.m_jNode.slideDown(200);
        if (gThis.m_oOptions.sName != undefined) {
            $(gThis.m_gForm).find('.form-navigation li:has(a[href="#' + gThis.m_oOptions.sName + '"])').css('display', 'block');
        }
    };

    gThis.Hide = function () {
        gThis.Ignore();
        gThis.m_jNode.slideUp(150);
        if (gThis.m_oOptions.sName != undefined) {
            $(gThis.m_gForm).find('.form-navigation li:has(a[href="#' + gThis.m_oOptions.sName + '"])').css('display', 'none');
        }
    };

};