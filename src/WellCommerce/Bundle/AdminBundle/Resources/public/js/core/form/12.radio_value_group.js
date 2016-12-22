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
    oImages: {
        sCalendarIcon: 'images/icons/buttons/calendar.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormRadioValueGroup = GCore.ExtendClass(GFormField, function () {

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
        for (var i = 0; i < gThis.m_oOptions.aoOptions.length; i++) {
            var oOption = gThis.m_oOptions.aoOptions[i];
            var jInput = $('<input type="radio" name="' + gThis.GetName() + '[value]" value="' + oOption.sValue + '">');
            if (gThis.m_jField instanceof $) {
                gThis.m_jField = gThis.m_jField.add(jInput);
            }
            else {
                gThis.m_jField = jInput;
            }
            var iPosition;
            if ((iPosition = oOption.sLabel.indexOf('%input%')) != -1) {
                var jLabel = $('<label/>');
                jLabel.append('<span>' + oOption.sLabel.substr(0, iPosition) + '</span>');
                var jInnerInput = $('<input type="text" name="' + gThis.GetName() + '[' + oOption.sValue + ']" value=""/>');
                jLabel.append($('<span class="inner-field-text"/>').append(jInnerInput));
                jLabel.append('<span>' + oOption.sLabel.substr(iPosition + 7) + '</span>');
            }
            else if ((iPosition = oOption.sLabel.indexOf('%date%')) != -1) {
                var jLabel = $('<label/>');
                jLabel.append('<span>' + oOption.sLabel.substr(0, iPosition) + '</span>');
                var jInnerInput = $('<input class="date" type="text" name="' + gThis.GetName() + '[' + oOption.sValue + ']" value=""/>');
                var jTrigger = $('<img style="width: 16px; height: 16px; float: left; margin: 0 5px 0 0;" src="' + gThis._GetImage('CalendarIcon') + '" alt=""/>');
                jTrigger.css('cursor', 'pointer');
                jLabel.append($('<span class="inner-field-text"/>').append(jInnerInput)).append(jTrigger);
                jLabel.append('<span>' + oOption.sLabel.substr(iPosition + 6) + '</span>');
            }
            else if ((iPosition = oOption.sLabel.indexOf('%select%')) != -1) {
                var jLabel = $('<label/>');
                jLabel.append('<span>' + oOption.sLabel.substr(0, iPosition) + '</span>');
                var jInnerInput = $('<select name="' + gThis.GetName() + '[' + oOption.sValue + ']"/>');
                for (var j in gThis.m_oOptions.oSuboptions[oOption.sValue]) {
                    var oSuboption = gThis.m_oOptions.oSuboptions[oOption.sValue][j];
                    jInnerInput.append('<option value="' + oSuboption.value + '">' + oSuboption.label + '</option>');
                }
                jLabel.append($('<span class="inner-field-select"/>').append($('<span class="field"/>').append(jInnerInput)));
                jLabel.append('<span>' + oOption.sLabel.substr(iPosition + 8) + '</span>');
            }
            else {
                var jLabel = $('<label>' + oOption.sLabel + '</label>');
            }
            gThis.m_jNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jLabel.prepend(jInput)));
        }
    };

    gThis._InitializeEvents = function () {
        var f = function (eEvent) {
            if ($(this).is(':checked')) {
                $(this).closest('.field').find('input:text').focus();
            }
        };
        gThis.m_jField.change(f).click(f);
        gThis.m_jField.closest('.field').find('select').GSelect();
        gThis.m_jField.closest('.field').find('.inner-field-text input').focus(function (eEvent) {
            $(this).parent().addClass('focus');
            $(this).closest('.field').find('input:radio:not(:checked)').click();
        }).blur(function (eEvent) {
            $(this).parent().removeClass('focus');
        });
        gThis.m_jField.closest('.field').find('.inner-field-select select').focus(function (eEvent) {
            $(this).parent().addClass('focus');
        }).blur(function (eEvent) {
            $(this).parent().removeClass('focus');
            $(this).closest('.field').find('input:radio:not(:checked)').click();
        }).change(function (eEvent) {
            $(this).closest('.field').find('input:radio:not(:checked)').click();
        });
        gThis.m_jNode.find('input.date').datepicker();
    };

    gThis.SetValue = function (mValue) {
        for (var i in mValue) {
            if (i == 'value') {
                if ((gThis.m_jField != undefined) && (gThis.m_jField.length)) {
                    gThis.m_jField.filter('[value="' + mValue[i] + '"]').click();
                }
            }
            else {
                gThis.m_jNode.find('input:text[name="' + gThis.GetName() + '[' + i + ']"]').val(mValue[i]);
                gThis.m_jNode.find('select[name="' + gThis.GetName() + '[' + i + ']"]').val(mValue[i]).change();
            }
        }
    };

    gThis.Reset = function () {
    };

}, oDefaults);