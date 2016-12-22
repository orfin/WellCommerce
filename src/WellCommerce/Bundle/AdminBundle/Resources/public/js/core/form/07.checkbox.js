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
        sFieldClass: 'field-checkbox',
        sFieldSpanClass: 'field',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition'
    },
    sFieldType: 'checkbox',
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormCheckbox = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        return (gThis._GetField(sRepetition).is(':checked')) ? gThis._GetField(sRepetition).attr('value') : '';
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (gThis._GetField(sRepetition).attr('value') == mValue) {
            gThis._GetField(sRepetition).parent().checkCheckboxes();
        }
        else {
            gThis._GetField(sRepetition).parent().unCheckCheckboxes();
        }
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        gThis.m_jNode.append(jLabel);
        gThis.m_jHiddenField = $('<input type="hidden" name="' + gThis.GetName() + '" value="0"/>');
        gThis.m_jField = $('<input type="' + gThis.m_oOptions.sFieldType + '" name="' + gThis.GetName() + '" id="' + gThis.GetId() + '" value="1"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(gThis.m_jHiddenField).append(gThis.m_jField));
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jRepetitionNode.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jRepetitionNode);
    };

    gThis.OnFocus = function (eEvent) {
        var jField = $(eEvent.currentTarget);
        jField.closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
        gThis._ActivateFocusedTab(eEvent);
    };

    gThis.OnBlur = function (eEvent) {
        var jField = $(eEvent.currentTarget);
        jField.closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
    };

    gThis.Reset = function () {
        gThis.m_jField.val(gThis.m_oOptions.sDefault);
    };

}, oDefaults);