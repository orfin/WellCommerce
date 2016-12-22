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
        sFieldClass: 'field-select',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sDisabledClass: 'disabled',
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
    sComment: '',
    sSelector: '',
    sCssAttribute: '',
    sAddItemPrompt: '',
    bAddable: false,
    fOnAdd: GCore.NULL,
    sAddItemPrompt: '',
};

var GFormSelect = GCore.ExtendClass(GFormField, function() {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_bResized = false;

    gThis.GetValue = function(sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        return gThis._GetField(sRepetition).find('option:selected').attr('value');
    };

    gThis.SetValue = function(mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        var jField = gThis._GetField(sRepetition);
        jField.val(mValue);
        if ((jField.get(0) != undefined) && (jField.get(0).Update != undefined)) {
            jField.get(0).Update.apply(jField.get(0));
        }
    };

    gThis.ExchangeOptions = function(aoNewOptions) {
        var sOldValueId = gThis.m_jField.val();
        gThis.m_oOptions.aoOptions = aoNewOptions;
        var jOldNode = gThis.m_jNode;
        gThis.m_jField = GCore.NULL;
        gThis._PrepareNode();
        gThis.m_jNode.addClass('GFormNode').get(0).gNode = gThis;
        jOldNode.replaceWith(gThis.m_jNode);
        gThis.m_bShown = false;
        gThis.m_bResized = false;
        gThis.OnShow();
        if (gThis.m_jField.find('option[value="' + sOldValueId + '"]').length) {
            gThis.m_jField.val(sOldValueId);
        }
        gThis._InitializeDependencies();
        gThis.m_jField.change();
    };

    gThis._PrepareNode = function() {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        if (!gThis.m_bRepeatable) {
            gThis.m_jNode.append(gThis._AddField());
        }
        else {
            gThis.AddRepetition();
        }
        if ((gThis.m_oOptions.sSelector != undefined) && (gThis.m_oOptions.sSelector.length)) {
            gThis.m_jField.attr('name', gThis.GetName() + '[value]');
            gThis.m_jNode.append('<input type="hidden" name="' + gThis.GetName() + '[selector]" value="' + gThis.m_oOptions.sSelector + '"/>');
        }
        if ((gThis.m_oOptions.sCssAttribute != undefined) && (gThis.m_oOptions.sCssAttribute.length)) {
            gThis.m_jField.attr('name', gThis.GetName() + '[value]');
            gThis.m_jNode.append('<input type="hidden" name="' + gThis.GetName() + '[css_attribute]" value="' + gThis.m_oOptions.sCssAttribute + '"/>');
        }
    };

    gThis._AddField = function(sId) {
        var jField = $('<select name="' + gThis.GetName(sId) + '" id="' + gThis.GetId(sId) + '"/>');
        for (var i = 0; i < gThis.m_oOptions.aoOptions.length; i++) {
            var oOption = gThis.m_oOptions.aoOptions[i];
            jField.append('<option value="' + oOption.sValue + '">' + oOption.sLabel + '</option>');
        }
        if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
            gThis.m_jField = gThis.m_jField.add(jField);
        }
        else {
            gThis.m_jField = jField;
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        if (gThis.m_oOptions.sPrefix != undefined) {
            var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
            jPrefix.html(gThis.m_oOptions.sPrefix);
            jRepetitionNode.append(jPrefix);
        }
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jRepetitionNode.append(jSuffix);
        }

        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {
            gThis.m_jTrigger = $('<a href="#" class="' + gThis._GetClass('AddRepetition') + '"/>').append('<img src="' + gThis._GetImage('AddRepetition') + '" alt="' + GForm.Language.add_field_repetition + '" title="' + GForm.Language.add_field_repetition + '"/>');
            jRepetitionNode.append(gThis.m_jTrigger);
        }
        var jError = $('<span class="' + gThis._GetClass('Required') + '"/>');
        jRepetitionNode.append(jError);
        gThis.jRepetitionNode = jRepetitionNode;
        return gThis.jRepetitionNode;
    };

    gThis.OnInitRepetition = function(sRepetition) {
        if (!gThis.m_bShown) {
            return;
        }
        gThis._GetField(sRepetition).GSelect();
    };

    gThis.OnShow = function() {
        gThis._UpdateRepetitionButtons();
        if (!gThis.m_bShown && gThis.m_bRepeatable) {
            gThis._InitializeEvents('new-0');
        }
        gThis.m_bShown = true;
        if (gThis.m_bRepeatable) {
            for (var i in gThis.m_oRepetitions) {
                if (!gThis.m_oRepetitions[i].m_bResized) {
                    gThis.m_oRepetitions[i].m_bResized = true;
                    gThis.OnInitRepetition(i);
                }
            }
        }
        else {
            if (!gThis.m_bResized) {
                gThis.m_bResized = true;
                gThis.OnInitRepetition();
            }
        }
        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {
            gThis.m_jTrigger.click(function() {
                GAlert.DestroyAll();
                GPrompt(gThis.m_oOptions.sAddItemPrompt, function(sName) {
                    GCore.StartWaiting();
                    gThis.m_oOptions.fOnAdd({
                        name: sName
                    }, GCallback(function(eEvent) {
                        GCore.StopWaiting();
                        GAlert.DestroyAll();
                        if(!eEvent.error){
                            gThis.ExchangeOptions(eEvent.options);
                            gThis.SetValue(eEvent.id);
                            gThis.m_jField.triggerHandler('change');
                        }else{
                            GError(eEvent.error);
                        }
                    }));
                });
                return false;
            });
        }
    };

    gThis.OnFocus = function(eEvent) {
        $(eEvent.currentTarget).closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
        gThis._ActivateFocusedTab(eEvent);
    };

    gThis.OnBlur = function(eEvent) {
        $(eEvent.currentTarget).closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
    };

    gThis.Reset = function() {
        gThis.m_jField.val(gThis.m_oOptions.sDefault).change();
    };

    gThis._InitializeEvents = function(sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (gThis.m_bRepeatable && (sRepetition == undefined)) {
            return;
        }
        var jField = gThis._GetField(sRepetition);
        jField.focus(gThis.OnFocus);
        jField.blur(gThis.OnBlur);
        jField.each(function() {
            $(this).change(GEventHandler(function(eEvent) {
                gThis.Validate(false, this.sRepetition);
            }));
        });
        jField.keydown(function(eEvent) {
            var dSelect = this;
            setTimeout(function() {
                dSelect.Update();
            }, 50);
            return true;
        });
        if (gThis.m_jNode.closest('.statusChange').length) {
            gThis.OnShow();
        }
    };

}, oDefaults);