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

var GCallback = function (fHandler, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }
    var i = GCallback.s_iReferenceCounter++;
    GCallback.s_aoReferences[i] = {
        fHandler: fHandler,
        oParams: oParams
    };
    GCallback['Trigger_' + i] = function () {
        GCallback.Invoke(i, GCore.GetArgumentsArray(arguments));
    };
    return 'GCallback.Trigger_' + i + '';
};

GCallback.s_iReferenceCounter = 0;
GCallback.s_aoReferences = {};

GCallback.Invoke = function (iReference, amArguments) {
    if (amArguments[0] == undefined) {
        amArguments[0] = {};
    }
    var oReference = GCallback.s_aoReferences[iReference];
    if (oReference != undefined) {
        oReference.fHandler.call(this, $.extend(oReference.oParams, amArguments[0]));
    }
    delete GCallback.s_aoReferences[iReference];
};