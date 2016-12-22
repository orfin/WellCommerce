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
    oClasses: {
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
    aoRules: [],
    sComment: ''
};

var GFormField = GCore.ExtendClass(GFormNode, function () {

    var gThis = this;

    gThis.m_jField = $('empty');
    gThis.m_oAlerts = {};
    gThis.m_oRepetitionLookup = {};
    gThis.m_sRepetitionCounter = 0;
    gThis.m_oRepetitions = {};
    gThis.m_bAlreadyPopulated = false;
    gThis.m_bSkipValidation = false;
    gThis.m_afDependencyTriggers = [];

    gThis.Populate = function (mData) {
        var i;
        if (gThis.m_bRepeatable) {
            if (GCore.ObjectLength(mData) && !gThis.m_bAlreadyPopulated) {
                gThis.m_bAlreadyPopulated = true;
                for (i in gThis.m_oRepetitions) {
                    gThis.RemoveRepetition(i);
                }
            }
            for (i in mData) {
                if (gThis.m_oRepetitions[i] == undefined) {
                    gThis.AddRepetition(i);
                }
                gThis.SetValue(mData[i], i);
            }
        }
        else {
            gThis.SetValue(mData);
        }
    };

    gThis.AddRepetition = function (sRepetition) {
        if (sRepetition == undefined) {
            sRepetition = 'new-' + gThis.m_sRepetitionCounter++;
        }
        var jRepetition = gThis._AddField(sRepetition);
        gThis.m_jNode.append(jRepetition);
        gThis.m_oRepetitions[sRepetition] = jRepetition;
        jRepetition.get(0).sRepetition = sRepetition;
        gThis._GetField(sRepetition).get(0).sRepetition = sRepetition;
        gThis._InitializeEvents(sRepetition);
        gThis._UpdateRepetitionButtons();
        gThis.OnInitRepetition(sRepetition);
        return sRepetition;
    };

    gThis.OnInitRepetition = function (sRepetition) {
    };

    gThis.RemoveRepetition = function (sRepetition) {
        gThis._RemoveAlerts(sRepetition);
        gThis.m_oRepetitions[sRepetition].addClass('to-remove');
        gThis.m_jField = gThis.m_jField.not('.to-remove *');
        gThis.m_oRepetitions[sRepetition].remove();
        delete gThis.m_oRepetitions[sRepetition];
        gThis._UpdateRepetitionButtons();
    };

    gThis.PopulateErrors = function (mData) {
        if ((mData == undefined) || (mData == '')) {
            return;
        }
        if (gThis.m_bRepeatable) {
            for (var i in mData) {
                if (gThis.m_oRepetitions[i] == undefined) {
                    gThis.AddRepetition(i);
                }
                gThis.SetError(mData[i], i);
            }
        }
        else {
            gThis.SetError(mData);
        }
    };

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        return gThis._GetField(sRepetition).val();
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        gThis._GetField(sRepetition).val(mValue);
    };

    gThis.Validate = function (bNoRequests, sRepetition) {
        if (gThis.m_bRepeatable && (sRepetition == undefined)) {
            for (var j in gThis.m_oRepetitions) {
                gThis._RemoveAlerts(j);
            }
            if (gThis.m_bIgnore || (gThis.m_oOptions.aoRules == undefined)) {
                return true;
            }
            var bResult = true;
            for (j in gThis.m_oRepetitions) {
                for (var i = 0; i < gThis.m_oOptions.aoRules.length; i++) {
                    if (!GFormRule.Check(gThis.m_oOptions.aoRules[i], gThis, bNoRequests, j)) {
                        bResult = false;
                    }
                }
            }
            return bResult;
        }
        else {
            gThis._RemoveAlerts(sRepetition);
            if (gThis.m_bIgnore || (gThis.m_oOptions.aoRules == undefined)) {
                return true;
            }
            for (var i = 0; i < gThis.m_oOptions.aoRules.length; i++) {
                if (!GFormRule.Check(gThis.m_oOptions.aoRules[i], gThis, bNoRequests, sRepetition)) {
                    return false;
                }
            }
        }
        return true;
    };

    gThis.OnRemove = function () {
        gThis._RemoveAlerts();
    };

    gThis._RemoveAlerts = function (sRepetition) {
        var i;
        if (sRepetition == undefined) {
            if (gThis.m_bRepeatable) {
                for (var j in gThis.m_oRepetitions) {
                    for (i in gThis.m_oAlerts[j]) {
                        GAlert.Destroy(gThis.m_oAlerts[j][i]);
                    }
                }
            }
            else {
                for (i in gThis.m_oAlerts[0]) {
                    GAlert.Destroy(gThis.m_oAlerts[0][i]);
                }
            }
        }
        else {
            if (gThis.m_oAlerts[sRepetition] != undefined) {
                for (i in gThis.m_oAlerts[sRepetition]) {
                    GAlert.Destroy(gThis.m_oAlerts[sRepetition][i]);
                }
            }
        }
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().find('.required').html('');
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().removeClass(gThis._GetClass('Invalid'));

    };

    gThis.StartWaiting = function (sRepetition) {
        var jWaiting = $('<span class="' + gThis._GetClass('Waiting') + '"/>');
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().append(jWaiting);
        jWaiting.css('display', 'none').fadeIn(250);
    };

    gThis._GetField = function (sRepetition) {
        if (!gThis.m_bRepeatable || (sRepetition == undefined)) {
            return gThis.m_jField;
        }
        if (gThis.m_oRepetitions[sRepetition] == undefined) {
            return $();
        }
        gThis.m_oRepetitions[sRepetition].addClass('to-retrieve');
        var jField = gThis.m_jField.filter('.to-retrieve *');
        gThis.m_oRepetitions[sRepetition].removeClass('to-retrieve');
        return jField;
    };

    gThis.StopWaiting = function (sRepetition) {
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().find('.' + gThis._GetClass('Waiting')).fadeOut(250, function () {
            $(this).remove();
        });
    };

    gThis.ValidationResult = function (bResult, sMessage, sRepetition) {
        if (!bResult) {
            gThis.SetError(sMessage, sRepetition);
        }
        return bResult;
    };

    gThis.SetError = function (sMessage, sRepetition) {
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().addClass(gThis._GetClass('Invalid'));
        gThis._GetField(sRepetition).closest('.' + gThis._GetClass('FieldSpan')).parent().find('.required').html(sMessage).fadeOut(150, function () {
            $(this).fadeIn(150, function () {
                $(this).fadeOut(150, function () {
                    $(this).fadeIn(150, function () {
                    });
                });
            });
        });
    };

    gThis._InitializeEvents = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (gThis.m_bRepeatable && (sRepetition == undefined)) {
            return;
        }
        var jField = gThis._GetField(sRepetition);
        jField.focus(gThis.OnFocus);
        jField.blur(gThis.OnBlur);
        jField.each(function () {
            $(this).unbind('change', gThis.OnValidate).change(gThis.OnValidate);
        });
    };

    gThis._ActivateFocusedTab = function (eEvent) {
        if ($(eEvent.currentTarget).closest('.ui-tabs-panel').length && $(eEvent.currentTarget).closest('.ui-tabs-panel').hasClass('ui-tabs-hide')) {
            gThis.m_gForm.m_bDontFocus = true;
            $(eEvent.currentTarget).closest('.ui-tabs').tabs('select', $(eEvent.currentTarget).closest('.ui-tabs-panel').attr('id'));
        }
    };

    gThis.OnFocus = function (eEvent) {
        gThis._ActivateFocusedTab(eEvent);
    };

    gThis.OnBlur = function (eEvent) {
    };

    gThis.OnValidate = GEventHandler(function (eEvent) {
        if (!$(this).closest('.GFormNode').get(0).gNode.m_bSkipValidation) {
            gThis.Validate(false, this.sRepetition);
        }
    });

    gThis.Focus = function (sRepetition) {
        gThis._GetField(sRepetition).eq(0).focus();
        return true;
    };

    gThis._UpdateRepetitionButtons = function () {
        if (!gThis.m_bRepeatable) {
            return;
        }
        for (var j in gThis.m_oRepetitions) {
            gThis.m_oRepetitions[j].find('.' + gThis._GetClass('RemoveRepetition') + ', .' + gThis._GetClass('AddRepetition')).remove();
        }
        var jRepetitions = gThis.m_jNode.find('.' + gThis._GetClass('FieldRepetition'));
        var jTrigger;
        for (var i = 0; i < jRepetitions.length; i++) {
            if ((i == jRepetitions.length - 1) && (GCore.ObjectLength(gThis.m_oRepetitions) < gThis.m_oOptions.oRepeat.iMax)) {
                jTrigger = $('<a href="#" class="' + gThis._GetClass('AddRepetition') + '"/>').append('<img src="' + gThis._GetImage('AddRepetition') + '" alt="' + GForm.Language.add_field_repetition + '" title="' + GForm.Language.add_field_repetition + '"/>');
                jRepetitions.eq(i).find('.' + gThis._GetClass('FieldSpan')).after(jTrigger);
                jTrigger.click(function () {
                    gThis.AddRepetition();
                    return false;
                });
            }
            if (jRepetitions.length > 1) {
                jTrigger = $('<a href="#" class="' + gThis._GetClass('RemoveRepetition') + '"/>').append('<img src="' + gThis._GetImage('RemoveRepetition') + '" alt="' + GForm.Language.remove_field_repetition + '" title="' + GForm.Language.remove_field_repetition + '"/>');
                jRepetitions.eq(i).find('.' + gThis._GetClass('FieldSpan')).after(jTrigger);
                var sRepetition = jRepetitions.get(i).sRepetition;
                jTrigger.click(function () {
                    gThis.RemoveRepetition($(this).closest('.' + gThis._GetClass('FieldRepetition')).get(0).sRepetition);
                    return false;
                });
            }
        }
    };

}, oDefaults);