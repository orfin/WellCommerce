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
        sFieldClass: 'field-multiselect',
        sFieldSpanClass: 'field',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition'
    },
    oImages: {
        sAddRepetition: 'images/icons/buttons/add.png',
        sRemoveRepetition: 'images/icons/buttons/delete.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormMultiSelect = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_jUnmodified;

    gThis._Constructor = function () {
        gThis.m_bResized = false;
    };

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        var aValues = [];
        var jValues = gThis._GetField(sRepetition).filter(':checked');
        for (var i in jValues) {
            aValues.push(jValues.eq(i).attr('value'));
        }
        return aValues;
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        gThis._GetField(sRepetition).val(mValue).change();
    };

    gThis.ExchangeOptions = function (aoNewOptions) {
        gThis.m_oOptions.aoOptions = aoNewOptions;
        var jOldNode = gThis.m_jNode;
        gThis._PrepareNode();
        jOldNode.replaceWith(gThis.m_jNode);
        gThis.m_bShown = false;
        gThis.m_bResized = false;
        gThis.OnShow();
        gThis.m_jField.change();
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '" class="' + gThis._GetClass('Group') + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        gThis.m_jNode.append(gThis._AddField());
        gThis.m_jUnmodified = $('<input type="hidden" name="' + gThis.GetName() + '[unmodified]" value="1"/>');
        gThis.m_jNode.append(gThis.m_jUnmodified);
    };

    gThis._AddField = function (sId) {
        var jField = $('<ul/>');
        for (var i = 0; i < gThis.m_oOptions.aoOptions.length; i++) {
            var oOption = gThis.m_oOptions.aoOptions[i];
            jField.append('<li><label><input type="checkbox" name="' + gThis.GetName(sId) + '[' + oOption.sValue + ']" value="' + oOption.sValue + '"/>' + oOption.sLabel + '</label></li>');
        }
        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {
            gThis.m_jTrigger = $('<li><a style="padding-left: 8px;line-height: 19px;"href="#" class="' + gThis._GetClass('AddRepetition') + '"><img src="' + gThis._GetImage('AddRepetition') + '" alt="' + GForm.Language.add_field_repetition + '" title="' + GForm.Language.add_field_repetition + '"/> Dodaj nowy</a></li>');
            jField.append(gThis.m_jTrigger);
        }
        if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
            gThis.m_jField = gThis.m_jField.add(jField);
        }
        else {
            gThis.m_jField = jField;
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));

        var jError = $('<span class="' + gThis._GetClass('Required') + '"/>');
        jRepetitionNode.append(jError);

        return jRepetitionNode;
    };

    gThis.OnReset = function () {
        gThis.m_jNode.find('input').parent().unCheckCheckboxes();
    };

    gThis.OnShow = function () {
        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {
            gThis.m_jTrigger.click(function () {
                GAlert.DestroyAll();
                GPrompt(gThis.m_oOptions.sAddItemPrompt, function (sName) {
                    GCore.StartWaiting();
                    gThis.m_oOptions.fOnAdd({
                        name: sName
                    }, GCallback(function (eEvent) {
                        GCore.StopWaiting();
                        GAlert.DestroyAll();
                        if (!eEvent.error) {
                            gThis.ExchangeOptions(eEvent.options);
                            gThis.Populate(eEvent.id);
                        } else {
                            GError(eEvent.error);
                        }
                    }));
                });
                return false;
            });
        }
        gThis.m_jUnmodified.val('0');
    };

    gThis.Populate = function (mValue) {
        gThis.m_jNode.unCheckCheckboxes();
        for (var i in mValue) {
            if (i == 'unmodified') {
                continue;
            }
            gThis.m_jNode.find('input[value="' + mValue[i] + '"]').click();
        }
    };

    gThis.Focus = function () {
        if (gThis.m_jField == undefined) {
            return;
        }
        gThis.m_jField.eq(0).focus();
    };

}, oDefaults);