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

var GFormDate = GCore.ExtendClass(GFormTextField, function () {

    var gThis = this;

    gThis.m_jTrigger;

    gThis._Constructor = function () {
        gThis.m_jTrigger = $('<img style="width: 16px; height: 16px;" src="' + gThis._GetImage('CalendarIcon') + '" alt=""/>');
        gThis.m_oOptions.sSuffix = gThis.m_jTrigger.css('cursor', 'pointer');
    };

    gThis.OnShow = function () {
        gThis.m_bShown = true;
        if (!gThis.m_bResized) {
            gThis.m_bResized = true;
            var iWidth = parseInt(gThis.m_jField.css('width'));
            if (gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).length) {
                iWidth -= (gThis.m_jField.offset().left - gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
            }
            if (gThis.m_jNode.find('.' + gThis._GetClass('Suffix')).length) {
                iWidth -= 20;
            }
            gThis.m_jField.css('width', iWidth);
            gThis.m_jField.datepicker({
                minDate: gThis.m_oOptions.sMinDate,
                maxDate: gThis.m_oOptions.sMaxDate
            });
        }
    };

    gThis._InitializeEvents = function () {
        gThis.m_jTrigger.click(function () {
            gThis.m_jField.datepicker('show');
        });

        gThis.m_jField.unbind('change', gThis.OnValidate).change(gThis.OnValidate);
    };

}, oDefaults);