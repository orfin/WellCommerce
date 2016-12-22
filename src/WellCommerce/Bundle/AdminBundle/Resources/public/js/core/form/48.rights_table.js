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
        sFieldClass: 'field-rights-table',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition'
    },
    sDefault: '',
    aoRules: [],
    sComment: '',
    asControllers: [],
    asActions: []
};

var GFormRightsTable = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bDontCheck = false;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        gThis.m_jNode.append($('<span class="' + gThis._GetClass('FieldRepetition') + '"/>').append(gThis._PrepareTable()));
    };

    gThis._PrepareTable = function () {
        var jTr;
        var i;
        var j;
        var jTable = $('<table cellspacing="0"/>');
        var jHead = $('<thead/>');
        jTr = $('<tr/>');
        jTr.append('<th>&nbsp;</th>');
        for (i = 0; i < gThis.m_oOptions.asActions.length; i++) {
            jTr.append('<th>' + gThis.m_oOptions.asActions[i].name + '</th>');
        }
        jTr.append('<th class="all">' + GForm.Language.all_actions + '</th>');
        jHead.append(jTr);
        jTable.append(jHead);
        var jBody = $('<tbody/>');
        for (i = 0; i < gThis.m_oOptions.asControllers.length; i++) {
            jTr = $('<tr/>');
            jTr.append('<th scope="row">' + gThis.m_oOptions.asControllers[i].name + '</th>');
            for (j = 0; j < gThis.m_oOptions.asActions.length; j++) {
                jTr.append('<td><input type="hidden" value="0" name="' + gThis.GetName() + '[' + gThis.m_oOptions.asControllers[i].id + '][' + gThis.m_oOptions.asActions[j].id + ']"/><input type="checkbox" value="1" name="' + gThis.GetName() + '[' + gThis.m_oOptions.asControllers[i].id + '][' + gThis.m_oOptions.asActions[j].id + ']"/></td>');
            }
            jTr.append('<td class="all"><input type="checkbox"/></td>');
            jBody.append(jTr);
        }
        jTr = $('<tr class="all"/>');
        jTr.append('<th scope="row">' + GForm.Language.all_controllers + '</th>');
        for (j = 0; j < gThis.m_oOptions.asActions.length; j++) {
            jTr.append('<td><input type="checkbox"/></td>');
        }
        jTr.append('<td>&nbsp;</td>');
        jBody.append(jTr);
        jTable.append(jBody);
        return jTable;
    };

    gThis._Initialize = function () {
        gThis.m_jNode.find('tbody td, tbody th').hover(function () {
            $(this).closest('tr').addClass('active');
            var iIndex = $(this).closest('tr').find('td, th').index($(this).closest('td, th'));
            if (iIndex > 0) {
                $(this).closest('table').find('tr').each(function () {
                    $(this).find('td, th').eq(iIndex).addClass('active');
                });
            }
        }, function () {
            $(this).closest('tr').removeClass('active');
            var iIndex = $(this).closest('tr').find('td, th').index($(this).closest('td, th'));
            if (iIndex > 0) {
                $(this).closest('table').find('tr').each(function () {
                    $(this).find('td, th').eq(iIndex).removeClass('active');
                });
            }
        });
        gThis.m_jNode.find('td.all input').click(function () {
            if ($(this).is(':checked')) {
                $(this).closest('tr').checkCheckboxes();
            }
            else {
                $(this).closest('tr').unCheckCheckboxes();
            }
        });
        gThis.m_jNode.find('tr.all input').click(function () {
            var iIndex = $(this).closest('tr').find('td, th').index($(this).closest('td, th'));
            if ($(this).is(':checked')) {
                $(this).closest('table').find('tr').each(function () {
                    $(this).find('td, th').eq(iIndex).checkCheckboxes();
                });
            }
            else {
                $(this).closest('table').find('tr').each(function () {
                    $(this).find('td, th').eq(iIndex).unCheckCheckboxes();
                });
            }
        });
        gThis.m_jNode.find('input').not('.all input').click(gThis.OnInputChange).change(gThis.OnInputChange);
    };

    gThis.OnInputChange = function () {
        gThis._CheckHorizontal.apply(this);
        gThis._CheckVertical.apply(this);
    };

    gThis._CheckHorizontal = function () {
        if (gThis.m_bDontCheck) {
            return;
        }
        if ($(this).closest('tr').find('td:not(.all), th').find('input:not(:checked)').length) {
            $(this).closest('tr').find('.all').unCheckCheckboxes();
        }
        else {
            $(this).closest('tr').find('.all').checkCheckboxes();
        }
    };

    gThis._CheckVertical = function () {
        if (gThis.m_bDontCheck) {
            return;
        }
        var iIndex = $(this).closest('tr').find('td').index($(this).closest('td, th'));
        var jTrs = $(this).closest('table').find('tbody tr:not(.all)');
        var iLength = 0;
        for (var i = 0; i < jTrs.length; i++) {
            iLength += jTrs.eq(i).find('td:eq(' + iIndex + ') input:not(:checked)').length;
            if (iLength) {
                break;
            }
        }
        if (iLength) {
            $(this).closest('table').find('tbody tr.all td:eq(' + iIndex + ')').unCheckCheckboxes();
        }
        else {
            $(this).closest('table').find('tbody tr.all td:eq(' + iIndex + ')').checkCheckboxes();
        }
    };

    gThis.Populate = function (mData) {
        gThis.m_bDontCheck = true;
        for (var iController in mData) {
            for (var iAction in mData[iController]) {
                if (mData[iController][iAction]) {
                    gThis.m_jNode.find('input[name="' + gThis.GetName() + '[' + iController + '][' + iAction + ']"]').parent().checkCheckboxes();
                }
            }
        }
        gThis.m_bDontCheck = false;
        gThis.OnShow();
    };

    gThis.OnReset = function () {
        gThis.m_bDontCheck = true;
        gThis.m_jNode.unCheckCheckboxes();
        gThis.m_bDontCheck = false;
        gThis.OnShow();
    };

    gThis.OnShow = function () {
        gThis.m_jNode.find('tbody tr:not(.all)').each(function () {
            $(this).find('td:eq(0) input:checked').each(gThis._CheckHorizontal);
        });
        gThis.m_jNode.find('tbody tr:eq(0)').each(function () {
            $(this).find('td:not(.all) input:checked').each(gThis._CheckVertical);
        });
    };

}, oDefaults);