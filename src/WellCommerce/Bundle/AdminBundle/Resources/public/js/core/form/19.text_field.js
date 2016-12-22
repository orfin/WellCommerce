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
        sFieldClass: 'field-text',
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
    sFieldType: 'text',
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormTextField = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_bResized = false;

    gThis._PrepareNode = function () {

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

    gThis._AddField = function (sId) {
        var jField = $('<input type="' + gThis.m_oOptions.sFieldType + '" name="' + gThis.GetName(sId) + '" id="' + gThis.GetId(sId) + '"/>');

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
        if (gThis.m_oOptions.sSuffix != undefined && gThis.m_oOptions.sSuffix != '') {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jRepetitionNode.append(jSuffix);
        }
        var jError = $('<span class="' + gThis._GetClass('Required') + '"/>');
        jRepetitionNode.append(jError);
        gThis.jRepetitionNode = jRepetitionNode;
        return gThis.jRepetitionNode;
    };

    gThis.OnShow = function () {
        gThis._UpdateRepetitionButtons();
        if (!gThis.m_bShown && gThis.m_bRepeatable) {
            gThis._InitializeEvents('new-0');
        }
        gThis.m_bShown = true;
        if (gThis.m_bRepeatable) {
            for (var i in gThis.m_oRepetitions) {
                if (!gThis.m_oRepetitions[i].m_bResized) {
                    gThis.m_oRepetitions[i].m_bResized = true;
                    var iWidth = parseInt(gThis._GetField(i).css('width'));
                    if (gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Prefix')).length) {
                        iWidth -= (gThis._GetField(i).offset().left - gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
                    }
                    if (gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Suffix')).length) {
                        iWidth -= gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Suffix')).width() + 4;
                    }
                    gThis._GetField(i).eq(i).css('width', iWidth);
                }
            }
        }
        else {
            if (!gThis.m_bResized) {
                gThis.m_bResized = true;
                var iWidth = parseInt(gThis.m_jField.css('width'));
                if (gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).length) {
                    iWidth -= (gThis.m_jField.offset().left - gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
                }
                if (gThis.m_jNode.find('.' + gThis._GetClass('Suffix')).length) {
                    iWidth -= gThis.m_jNode.find('.' + gThis._GetClass('Suffix')).width() + 4;
                }
                gThis.m_jField.css('width', iWidth);
            }
        }
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

}, oDefaults);