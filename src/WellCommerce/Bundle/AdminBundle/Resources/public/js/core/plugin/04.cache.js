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

var GCache = function () {

    var gThis = this;

    this.m_oResponses;

    this._Constructor = function () {
        this.m_oResponses = {};
    };

    this.Execute = function (fHandler, oRequest, sCallback) {
        var sRequest = JSON.stringify(oRequest);
        if (this.m_oResponses[sRequest] != undefined) {
            gThis.ReturnResponse(sCallback, this.m_oResponses[sRequest]);
            return;
        }
        fHandler(oRequest, GCallback(this.SaveResponse, {
            sCallback: sCallback,
            sRequest: sRequest
        }));
    };

    this._CompareRequests = function (oA, oB) {
        for (var i in oA) {
            if (oA[i] != oB[i]) {
                return false;
            }
        }
        for (var j in oB) {
            if (oA[j] != oB[j]) {
                return false;
            }
        }
        return true;
    };

    this.ReturnResponse = function (sFunction, oResponse) {
        eval(sFunction + '(oResponse);');
    };

    this.SaveResponse = new GEventHandler(function (eEvent) {
        var sCallback = eEvent.sCallback;
        var sRequest = eEvent.sRequest;
        delete eEvent.sCallback;
        delete eEvent.sRequest;
        gThis.m_oResponses[sRequest] = eEvent;
        gThis.ReturnResponse(sCallback, eEvent);
    });

    this._Constructor();

};