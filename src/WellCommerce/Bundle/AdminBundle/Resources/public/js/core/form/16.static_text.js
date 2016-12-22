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
        sFieldClass: 'field-static-text'
    }
};

var GFormStaticText = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jNode.append(gThis.m_oOptions.sText);
    };

    gThis.Focus = function () {
        return false;
    };

}, oDefaults);