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
        sFieldClass: 'field-tip',
        sArrowClass: 'tip',
        sHideButtonClass: 'hide',
        sRetractableClass: 'retractable',
        sSwitchClass: 'switch'
    },
    sTip: '',
    sShortTip: '',
    bRetractable: false,
    sDirection: 'down',
    sDefaultState: 'retracted'
};

var GFormTip = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field')).addClass(gThis.m_oOptions.sDirection);
        gThis.m_jNode.append('<div class="' + gThis._GetClass('Arrow') + '"/>');
        gThis.m_jNode.append($('<div class="long"/>').append('<p>' + gThis.m_oOptions.sTip + '</p>'));
        if (gThis.m_oOptions.bRetractable) {
            gThis.m_jNode.addClass(gThis._GetClass('Retractable'));
            if (gThis.m_oOptions.sDefaultState == 'retracted') {
                gThis.m_jNode.addClass('retracted');
            }
            gThis.m_jNode.append($('<div class="' + gThis._GetClass('Switch') + '"/>'));
            gThis.m_jNode.append($('<div class="short"/>').append(gThis.m_oOptions.sShortTip));
        }
    };

    gThis._InitializeEvents = function () {
        gThis.m_jNode.find('.' + gThis._GetClass('Switch')).click(function () {
            gThis.m_jNode.toggleClass('retracted');
            return false;
        });
    };

    gThis.Focus = function () {
        return false;
    };

}, oDefaults);