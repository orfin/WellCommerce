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
        sFieldClass: 'field-datetime',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition'
    },
    oImages: {
        sCalendarIcon: 'images/icons/buttons/calendar.png'
    },
    sFieldType: 'text',
    sDefault: '',
    aoRules: [],
    sComment: '',
    sMinDate: null,
    sMaxDate: null
};

var GFormDateTime = GCore.ExtendClass(GFormDate, function () {

    var gThis = this;

    gThis.m_jTrigger;

    gThis._Constructor = function () {
        gThis.m_jTrigger = $('<img style="width: 16px; height: 16px;" src="' + gThis._GetImage('CalendarIcon') + '" alt=""/>');
        gThis.m_oOptions.sSuffix = gThis.m_jTrigger.css('cursor', 'pointer');
    };

    gThis._AddField = function (sId) {
        var jField = $('<input type="' + gThis.m_oOptions.sFieldType + '" name="' + gThis.GetName(sId) + '[d]" id="' + gThis.GetId(sId) + '_d"/>');
        if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
            gThis.m_jField = gThis.m_jField.add(jField);
        }
        else {
            gThis.m_jField = jField;
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jSuffix.append(' ' + GForm.Language.datetime_hour);
            jRepetitionNode.append(jSuffix);
        }

        jField = $('<select name="' + gThis.GetName(sId) + '[h]" id="' + gThis.GetId(sId) + '_h"/>');
        for (var i = 0; i < 24; i++) {
            jField.append('<option value="' + i + '">' + ((i < 10) ? '0' + i : i) + '</option>');
        }
        gThis.m_jField = gThis.m_jField.add(jField);
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));

        jField = $('<select name="' + gThis.GetName(sId) + '[m]" id="' + gThis.GetId(sId) + '_m"/>');
        for (var i = 0; i < 60; i++) {
            jField.append('<option value="' + i + '">' + ((i < 10) ? '0' + i : i) + '</option>');
        }
        gThis.m_jField = gThis.m_jField.add(jField);
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));

        return jRepetitionNode;
    };

    gThis.OnShow = function () {
        if (gThis.m_bShown) {
            return;
        }
        gThis.m_bShown = true;
        gThis.m_jField.filter('input').datepicker({
            minDate: gThis.m_oOptions.sMinDate,
            maxDate: gThis.m_oOptions.sMaxDate
        });
        var jField = gThis.m_jField.filter('select');
        jField.focus(gThis.OnFocus);
        jField.blur(gThis.OnBlur);
        jField.each(function () {
            $(this).change(GEventHandler(function (eEvent) {
                gThis.Validate(false, this.sRepetition);
            }));
        });
        jField.keydown(function (eEvent) {
            var dSelect = this;
            setTimeout(function () {
                dSelect.Update();
            }, 50);
            return true;
        });
    };

    gThis._InitializeEvents = function () {
        gThis.m_jTrigger.click(function () {
            gThis.m_jField.filter('input').datepicker('show');
        });
        gThis.m_jField.filter('select').GSelect();
    };

    gThis.SetValue = function (mValue) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (mValue != undefined) {
            gThis.m_jField.filter('input[name$="[d]"]').val(mValue.d);
            gThis.m_jField.filter('select[name$="[h]"]').val(mValue.h);
            gThis.m_jField.filter('select[name$="[m]"]').val(mValue.m);
        }
    };

}, oDefaults);