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
        sFieldClass: 'field-image',
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
    iHeight: 27
};

var GFormProgressIndicator = GCore.ExtendClass(GFormFile, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }

        gThis.m_jNode.append('<h4>' + gThis.m_oOptions.sLabel + '</h4>');
        gThis.m_jNode.append('<p class="' + gThis._GetClass('Progress') + '"/>');
        gThis.m_jNode.append('<div class="' + gThis._GetClass('ProgressBar') + '"><div class="' + gThis._GetClass('ProgressBarIndicator') + '"></div>');
        gThis.m_jNode.find('.' + gThis._GetClass('Progress')).text(GForm.Language.progress_indicator_run_comment);
        gThis.m_jNode.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', 0 + '%');

        if (gThis.m_oOptions.bPreventSubmit) {
            jA = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
            jA.append('<span>' + GForm.Language.progress_indicator_run + '</span>');
            gThis.m_jNode.append($('<p></p>').append('<br />').append(jA));
        } else {
            window.setTimeout(gThis.OnLoad, 1500);
        }
    };

    gThis._InitializeEvents = function (sRepetition) {
        $('.navigation').remove();
        if (gThis.m_oOptions.bPreventSubmit) {
            jA.click(gThis.OnLoad);
        }

    };

    gThis.OnLoad = function () {
        if (gThis.m_oOptions.bPreventSubmit) {
            jA.hide();
        }

        gThis.m_oOptions.fLoadRecords({
            iStartFrom: 0
        }, GCallback(gThis.OnDataLoaded));
    };

    gThis.OnStartProcess = function (iFrom) {
        GXajaxInterface.Invoke(gThis.m_oOptions.fProcessRecords, [
            {
                iStartFrom: iFrom,
                iChunks: gThis.m_oOptions.iChunks,
                iTotal: gThis.iTotal
            },
            GCallback(gThis.OnProcess)
        ], function (eEvent) {
            GError('Serwer zwrócił niepoprawną odpowiedź', 'Czy spróbować jeszcze raz?', {
                aoPossibilities: [
                    {
                        mLink: GEventHandler(function (eEvent) {
                            GAlert.DestroyAll();
                            gThis.OnStartProcess(iFrom);
                        }),
                        sCaption: 'Ponów próbę'
                    },
                    {
                        mLink: GAlert.DestroyThis,
                        sCaption: GMessageBar.Language.cancel
                    }
                ]
            });
        });
    };

    gThis.UpdateIndicator = function (completed) {
        var iCompleted = completed;
        if (gThis.iTotal == undefined) {
            return;
        }
        var iTotal = gThis.iTotal;
        var iPercentage = Math.round(iCompleted / iTotal * 100);
        gThis.m_jNode.find('.' + gThis._GetClass('Progress')).text(iPercentage + '%: ' + iCompleted + ' / ' + iTotal + ' ' + gThis.m_oOptions.sComment);
        gThis.m_jNode.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', (iCompleted / iTotal * 100) + '%');
    };

    gThis.OnDataLoaded = GEventHandler(function (eEvent) {
        var iCompleted = eEvent.iCompleted;
        var iTotal = eEvent.iTotal;
        var iPercentage = Math.round(iCompleted / iTotal * 100);
        gThis.m_jNode.find('.' + gThis._GetClass('Progress')).text(iPercentage + '%: ' + iCompleted + ' / ' + iTotal + ' ' + gThis.m_oOptions.sComment);
        gThis.iTotal = iTotal;
        gThis.m_jNode.find('h4').text('Przetwarzanie danych');
        gThis.OnStartProcess(iCompleted, 0);
    });

    gThis.OnProcess = GEventHandler(function (eEvent) {
        gThis.UpdateIndicator(eEvent.iStartFrom);
        if ((eEvent.bFinished != undefined) && eEvent.bFinished) {
            gThis.m_oOptions.fSuccessRecords({
                bFinished: eEvent.bFinished
            }, GCallback(gThis.OnProcessSucceded));
            return;
        }
        if (eEvent.iStartFrom > 0) {
            gThis.OnStartProcess(eEvent.iStartFrom);
        }
    });

    gThis.OnProcessSucceded = GEventHandler(function (eEvent) {
        if ((eEvent.bCompleted != undefined) && eEvent.bCompleted) {
            GAlert(GForm.Language.progress_indicator_success);
            return;
        }
    });

}, oDefaults);