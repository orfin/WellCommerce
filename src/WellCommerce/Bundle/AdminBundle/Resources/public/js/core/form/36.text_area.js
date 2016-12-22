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
        sFieldClass: 'field-textarea',
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
        sAddRepetition: 'images/icons/buttons/add.png',
        sRemoveRepetition: 'images/icons/buttons/delete.png'
    },
    iRows: 3,
    iCols: 60,
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormTextArea = GCore.ExtendClass(GFormTextField, function () {

    var gThis = this;

    gThis.m_bResized;

    gThis._Constructor = function () {
        gThis.m_bResized = false;
    };

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
    };

    gThis._AddField = function (sId) {
        var jField = $('<textarea name="' + gThis.GetName() + '" id="' + gThis.GetId() + '" rows="' + gThis.m_oOptions.iRows + '" cols="' + gThis.m_oOptions.iCols + '"/>');
        if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
            gThis.m_jField = gThis.m_jField.add(jField);
        }
        else {
            gThis.m_jField = jField;
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
        return jRepetitionNode;
    };

    gThis.OnShow = function () {
    };

}, oDefaults);