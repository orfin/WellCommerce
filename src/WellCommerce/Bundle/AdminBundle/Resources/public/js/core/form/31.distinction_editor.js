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
        sFieldClass: 'field-price',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sDisabledClass: 'disabled',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition',
        sNetPriceClass: 'net-price',
        sGrossPriceClass: 'gross-price'
    },
    oImages: {
        sAddRepetition: 'images/icons/buttons/add.png',
        sRemoveRepetition: 'images/icons/buttons/delete.png',
        sCalendarIcon: 'images/icons/buttons/calendar.png'
    },
    sFieldType: 'text',
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormDistinctionEditor = GCore.ExtendClass(GFormTextField, function () {

    var gThis = this;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));

        for (var sId in gThis.m_oOptions.aoStatuses) {
            gThis._AddField(sId);
        }
    };

    gThis.Focus = function () {
        return false;
    };

    gThis.GetValue = function (sRepetition) {

    };

    gThis.SetValue = function (mValue, sRepetition) {
        for (var sId in mValue) {
            $('#' + gThis.GetId() + '__' + sId + '__enabled').parent().checkCheckboxes();
            $('#' + gThis.GetId() + '__' + sId + '__valid_from').val(mValue[sId].valid_from);
            $('#' + gThis.GetId() + '__' + sId + '__valid_to').val(mValue[sId].valid_to);
        }
    };

    gThis._AddField = function (sId) {
        var sLabel = gThis.m_oOptions.aoStatuses[sId];

        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(sLabel);
        gThis.m_jNode.append(jLabel);

        gThis.m_jHiddenField = $('<input type="hidden" name="' + gThis.GetName() + '[' + sId + '][enabled]" value="0"/>');
        gThis.m_jField = $('<input type="checkbox" name="' + gThis.GetName() + '[' + sId + '][enabled]" id="' + gThis.GetId() + '__' + sId + '__enabled" value="1"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(gThis.m_jHiddenField).append(gThis.m_jField));
        gThis.m_jNode.append(jRepetitionNode);

        gThis.m_jField = $('<input type="text" name="' + gThis.GetName() + '[' + sId + '][valid_from]" id="' + gThis.GetId() + '__' + sId + '__valid_from"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        gThis.m_jField.datepicker();
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(gThis.m_jField));
        gThis.m_jNode.append(jRepetitionNode);

        gThis.m_jField = $('<input type="text" name="' + gThis.GetName() + '[' + sId + '][valid_to]" id="' + gThis.GetId() + '__' + sId + '__valid_to"/>');
        gThis.m_jField.datepicker();
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(gThis.m_jField));
        gThis.m_jNode.append(jRepetitionNode);
    };

    gThis.OnShow = function () {

    };

    gThis._Initialize = function () {

    };

    gThis.Reset = function () {

    };


}, oDefaults);