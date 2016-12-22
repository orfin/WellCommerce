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
    iHeight: 27,
};

var GFormProgressBar = GCore.ExtendClass(GFormFile, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jNode.css({marginBottom: 20});
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        var iTotal = gThis.m_oOptions.iTotal;
        var iCompleted = gThis.m_oOptions.iCompleted;
        var iPercentage = Math.round(iCompleted / iTotal * 100);

        gThis.m_jNode.append('<h4>' + gThis.m_oOptions.sLabel + '</h4>');

        gThis.m_jNode.append('<p class="' + gThis._GetClass('Progress') + '"/>');

        gThis.m_jNode.append('<div class="' + gThis._GetClass('ProgressBar') + ((parseInt(iCompleted) > parseInt(iTotal) && parseInt(iTotal) > 0) ? ' error' : '') + '"><div class="' + gThis._GetClass('ProgressBarIndicator') + '"></div>');

        if (iTotal == 0) {
            gThis.m_jNode.find('.' + gThis._GetClass('Progress')).text('Brak limitu');
        } else {
            gThis.m_jNode.find('.' + gThis._GetClass('Progress')).text(Math.round(gThis.m_oOptions.iCompleted / gThis.m_oOptions.iTotal * 100) + '%: ' + gThis.m_oOptions.iCompleted + ' / ' + gThis.m_oOptions.iTotal + ' ' + gThis.m_oOptions.sComment);
        }

    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            var percentage = gThis.m_oOptions.iCompleted / gThis.m_oOptions.iTotal * 100;
            gThis.m_jNode.find('.' + gThis._GetClass('ProgressBarIndicator')).animate({
                width: (percentage > 100) ? '100%' : percentage + '%'
            }, 500);
        }
        gThis.m_bShown = true;
    };

}, oDefaults);