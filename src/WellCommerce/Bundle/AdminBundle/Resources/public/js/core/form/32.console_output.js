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
        sFieldClass: 'field-console-output',
        sFieldSpanClass: 'field',
        sButtonClass: 'button',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sThumbClass: 'thumb',
        sNameClass: 'name',
        sSelectedTableClass: 'selected',
        sAddFilesClass: 'add-pictures',
        sQueueClass: 'upload-queue',
        sProgressClass: 'progress',
        sProgressBarClass: 'progress-bar',
        sProgressBarIndicatorClass: 'indicator',
        sUploadErrorClass: 'upload-error',
        sUploadSuccessClass: 'upload-success'
    },
    oImages: {
        sDeleteIcon: 'images/icons/datagrid/delete.png',
        sUploadButton: 'images/buttons/add-pictures.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: '',
    iWidth: 121,
    iPort: 0,
    iHeight: 27,
};

var GFormConsoleOutput = GCore.ExtendClass(GFormFile, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.oSocket;
    gThis.oAjaxRequest;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jNode.css({marginBottom: 20});

        gThis.m_jButton = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
        gThis.m_jButton.append('<span>' + Translator.trans('package.button.run', {}, 'wellcommerce') + '</span>');
        gThis.m_jNode.append($('<p></p>').append('<br />').append(gThis.m_jButton));

        gThis.m_jButton.css({
            top: -20,
            position: 'relative',
            marginBottom: -5
        });

        gThis.m_jNode.append('<h4>' + Translator.trans('package.label.output', {}, 'wellcommerce') + '</h4>');

        gThis.m_jConsoleOutput = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jNode.append(gThis.m_jConsoleOutput);
        gThis.m_jConsoleOutput.append('<strong>' + Translator.trans('server.connection.starting', {}, 'wellcommerce') + '</strong>' + gThis.m_oOptions.iPort + '<br />');
    };

    gThis.OnProcess = function () {
        gThis.m_jButton.hide();
        var url = 'ws://127.0.0.1:' + gThis.m_oOptions.iPort + '/';
        gThis.oSocket = new WebSocket(url);
        gThis.oSocket.onmessage = function (msg) {
            gThis.m_jConsoleOutput.html(msg.data);
        };

        gThis.oSocket.onopen = function (eEvent) {
            console.log(eEvent);
            gThis.m_jConsoleOutput.append('<strong>' + Translator.trans('server.connection.open', {}, 'wellcommerce') + '</strong><br />');
        };

        gThis.oSocket.onclose = function (eEvent) {
            console.log(eEvent);
            gThis.m_jConsoleOutput.append('<strong>' + Translator.trans('server.connection.closed', {}, 'wellcommerce') + '</strong><br />');
        };

        gThis.oSocket.onerror = function (eEvent) {
            console.log(eEvent);
            gThis.m_jConsoleOutput.append('<strong>' + Translator.trans('server.connection.error', {}, 'wellcommerce') + ': ' + error + '</strong><br />');
        }
    };

    gThis._InitializeEvents = function (sRepetition) {
        $('.navigation .button').remove();
        gThis.m_jButton.click(gThis.OnProcess);
    };

    gThis.OnShow = function () {
        gThis.m_bShown = true;

        gThis.oAjaxRequest = GF_Ajax_Request(gThis.m_oOptions.sConsoleUrl, {}, function (oResponse) {
            if (oResponse.code == 0) {
                GMessage(Translator.trans('package.flash.install_success', {}, 'wellcommerce'));
            } else {
                GError(Translator.trans('package.flash.install_failed', {}, 'wellcommerce'), Translator.trans('package.flash.exit_code', {}, 'wellcommerce') + ': ' + oResponse.code);
            }

            gThis.oSocket.onclose = function () {
            };
            gThis.oSocket.close();
            gThis.oAjaxRequest.abort();
        });

        $(window).bind("beforeunload", function (event) {
            gThis.oAjaxRequest.abort();
            gThis.oSocket.onclose = function () {
            };
            gThis.oSocket.close();
            gThis.m_jConsoleOutput.append('<strong>' + Translator.trans('package.flash.request_terminated', {}, 'wellcommerce') + '</strong>');
            return Translator.trans('console.message.confirm', {}, 'wellcommerce');
        });
    };

}, oDefaults);