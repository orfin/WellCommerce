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
    sName: '',
    sLabel: '',
    oClasses: {
        sColumnsClass: 'layout-two-columns',
        sColumnClass: 'column'
    },
    aoFields: [],
    agFields: [],
    sClass: ''
};

var GFormColumns = GCore.ExtendClass(GFormContainer, function () {

    var gThis = this;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>');
        gThis.m_jNode.addClass(gThis._GetClass('Columns'));
        gThis.m_jNode.addClass(gThis.m_oOptions.sClass);
        gThis.m_jNode.attr('id', gThis.m_oOptions.sName);
        gThis.m_jNode.append(gThis.RenderChildren());
        gThis.m_jNode.children().addClass(gThis._GetClass('Column'));
    };

    gThis._InitializeEvents = function () {
        gThis.m_jNode.bind('GFormShow', function () {
            gThis.m_gForm.m_bFocused = false;
            gThis.OnShow();
        });
    };

    gThis.OnShow = function () {
        if (gThis.m_gForm.m_bDontFocus || (gThis.m_gForm != gThis.m_gParent)) {
            gThis.m_gForm.m_bFocused = true;
            gThis.m_gForm.m_bDontFocus = false;
        }
        for (var i = 0; i < gThis.m_oOptions.agFields.length; i++) {
            gThis.m_oOptions.agFields[i].OnShow();
            if (!gThis.m_gForm.m_bFocused) {
                gThis.m_gForm.m_bFocused = gThis.m_oOptions.agFields[i].Focus();
            }
        }
        return gThis.m_gForm.m_bFocused;
    };

}, oDefaults);