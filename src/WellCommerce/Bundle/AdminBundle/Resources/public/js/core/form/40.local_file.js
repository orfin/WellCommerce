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
        sFieldClass: 'field-localfile',
        sFieldSpanClass: 'field',
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
        sChooseIcon: 'images/icons/filetypes/directory.png',
        sDeleteIcon: 'images/icons/datagrid/delete.png',
        sUploadButton: 'images/buttons/add-pictures.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: '',
    sUploadUrl: '',
    sSessionId: '',
    sSessionName: '',
    asFileTypes: [],
    sFileTypesDescription: '',
    fDeleteFile: GCore.NULL,
    fLoadFiles: GCore.NULL,
    sSwfUploadUrl: '_data_panel/swfupload.swf',
    iWidth: 131,
    iHeight: 34,
    iMaxFileSize: 100 * 1024	// kB
};

var GFormLocalFile = GCore.ExtendClass(GFormFile, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_jFilesDatagrid;
    gThis.m_gDataProvider;
    gThis.m_gFilesDatagrid;
    gThis.m_jSelectedFiles;
    gThis.m_jSwfUpload;
    gThis.m_jQueue;
    gThis.m_iUploadsInProgress = 0;
    gThis.m_iLockId = -1;
    gThis.m_bLoadedDefaults = false;
    gThis.m_jChooseButton;
    gThis.m_jSelectedFileName;

    gThis.m_sCWD;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jNode.append(gThis._AddField());
    };

    gThis._AddField = function () {
        var jRepetition = $('<span class="repetition"/>');
        gThis.m_jField = $('<input type="file" name="file"/>');
        jRepetition.append(gThis.m_jField);
        return jRepetition;
    };
}, oDefaults);