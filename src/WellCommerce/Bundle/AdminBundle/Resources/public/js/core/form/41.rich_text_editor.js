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
        sFieldClass: 'field-rich-text-editor',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition',
        sLanguage: 'pl'
    },
    oImages: {
        sAddRepetition: 'images/icons/buttons/add.png',
        sRemoveRepetition: 'images/icons/buttons/delete.png'
    },
    iRows: 3,
    iCols: 60,
    sDefault: '',
    aoRules: [],
    sComment: '',
    bAdvanced: false,
    sLanguage: 'pl'
};

var GFormRichTextEditor = GCore.ExtendClass(GFormTextArea, function () {

    var gThis = this;

    gThis.OnShow = function () {
        if (gThis.m_bShown) {
            return;
        }
        var iDelay = 500;
        gThis.m_bShown = true;
        var editor = CKEDITOR.replace(gThis.GetId());
        editor.on('change', function (evt) {
            $('#' + gThis.GetId()).val(evt.editor.getData());
        });
    };
}, oDefaults);