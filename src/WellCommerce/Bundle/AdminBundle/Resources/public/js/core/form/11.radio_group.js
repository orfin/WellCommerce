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
        sFieldClass: 'field-radio-group',
        sFieldSpanClass: 'field',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormRadioGroup = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bResized;

    gThis._Constructor = function () {
        gThis.m_bResized = false;
    };

    gThis.GetValue = function () {
        return gThis.m_jField.filter(':checked').attr('value');
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label class="' + gThis._GetClass('Group') + '" for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        gThis.m_jField = $();
        for (var i = 0; i < gThis.m_oOptions.aoOptions.length; i++) {
            var oOption = gThis.m_oOptions.aoOptions[i];
            var jInput = $('<input type="radio" name="' + gThis.GetName() + '" value="' + oOption.sValue + '">');
            gThis.m_jField.add(jInput);
            gThis.m_jNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append($('<label>' + oOption.sLabel + '</label>').prepend(jInput)));
        }
    };

    gThis.SetValue = function (mValue) {
        if ((gThis.m_jField != undefined) && (gThis.m_jField instanceof $)) {
            gThis.m_jField.find(':radio[value="' + mValue + '"]').click();
        }
    };

    gThis.Reset = function () {
    };

}, oDefaults);