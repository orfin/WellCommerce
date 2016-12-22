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
    asDefaults: [],
    aoRules: [],
    sComment: '',
    sUploadUrl: '',
    sSessionId: '',
    sSessionName: '',
    asFileTypes: [],
    sFileTypesDescription: '',
    fDeleteHandler: GCore.NULL,
    fLoadFiles: GCore.NULL,
    sSwfUploadUrl: '_js_libs/swfupload.swf',
    iLimit: 100,
    iWidth: 131,
    iHeight: 34,
    iMaxFileSize: 100 * 1024
};

var GFormImage = GCore.ExtendClass(GFormFile, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_jFilesDatagrid;
    gThis.m_gFilesDatagrid;
    gThis.m_jSelectedFiles;
    gThis.m_jSwfUpload;
    gThis.m_jQueue;
    gThis.m_iUploadsInProgress = 0;
    gThis.m_iLockId = -1;
    gThis.m_bLoadedDefaults = false;
    gThis.m_jUnmodified;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jSwfUpload = $('<div class="' + gThis._GetClass('AddFiles') + '"><a href="#" class="button expand"><span id="' + gThis.GetId() + '__upload"><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GTranslation('media.button.add_from_disk') + '</span></a></div>');
        gThis.m_jNode.append(gThis.m_jSwfUpload);
        gThis.m_jChooseButton = $('<a href="#" class="button expand"><span><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GTranslation('media.button.select_from_library') + '</span></a>');
        gThis.m_jNode.append($('<span class="browse-pictures" style="float: right;margin-right: 5px;"/>').append(gThis.m_jChooseButton));
        gThis.m_jQueue = $('<ul class="' + gThis._GetClass('Queue') + '" id="' + gThis.GetId() + '__queue"/>');
        gThis.m_jNode.append(gThis.m_jQueue);
        gThis.m_jFilesDatagrid = $('<div/>').css('display', 'none');
        gThis.m_jNode.append(gThis.m_jFilesDatagrid);
        if (gThis.m_bRepeatable) {
            var jTable = $('<table class="' + gThis._GetClass('SelectedTable') + '" cellspacing="0"/>');
            var jThead = $('<thead/>');
            jThead.append('<th>' + GForm.Language.file_selector_photo + '</th>');
            jThead.append('<th>' + GForm.Language.file_selector_photo_main + '</th>');
            jThead.append('<th>' + GForm.Language.file_selector_photo_cancel + '</th>');
            gThis.m_jSelectedFiles = $('<tbody/>');
            jTable.append(jThead);
            jTable.append(gThis.m_jSelectedFiles);
            gThis.m_jNode.append(jTable);
            gThis.m_jField = $('<div/>');
        }
        else {
            gThis.m_jSelectedFiles = $('<div class="' + gThis._GetClass('SelectedTable') + '"/>');
            gThis.m_jNode.append(gThis.m_jSelectedFiles);
            gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '[0]"/>');
        }
        gThis.m_jNode.append(gThis.m_jField);
        gThis.m_jUnmodified = $('<input type="hidden" name="' + gThis.GetName() + '[unmodified]" value="1"/>');
        gThis.m_jNode.append(gThis.m_jUnmodified);
    };

    gThis.GetValue = function (sRepetition) {

        if (gThis.m_jField == undefined) {
            return '';
        }
        if (gThis.m_bRepeatable) {
            if (sRepetition != undefined) {
                return gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '"]').val();
            }
            var aValues = [];
            var jValues = gThis.m_jField.find('input');
            for (var i = 0; i < jValues.length; i++) {
                aValues.push(jValues.eq(i).val());
            }
            return aValues;
        }
        else {
            return gThis.m_jField.val();
        }
    };

    gThis._InitializeEvents = function () {
        gThis.m_jChooseButton.click(gThis._OnChoose);
    };

    gThis._OnChoose = GEventHandler(function (eEvent) {
        gThis.m_jFilesDatagrid.slideToggle(250);
        gThis.m_jChooseButton.toggleClass('expand');
        if (gThis.m_jChooseButton.hasClass('expand')) {
            gThis.m_jChooseButton.find('span').html('<img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_select);
        } else {
            gThis.m_jChooseButton.find('span').html('<img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_unselect);
        }
        return false;
    });

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (gThis.m_bRepeatable) {
            for (var i in mValue) {
                gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName(i) + '" value="' + mValue[i] + '"/>');
            }
        }
        else {
            gThis.m_jField.val(mValue);
        }
    };

    gThis.Populate = function (mValue) {
        if (gThis.m_bRepeatable) {
            gThis.m_jField.empty();
            gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
        }
        else {
            gThis.m_oOptions.sDefault = mValue;
        }

        if (!gThis.m_gFilesDatagrid) {
            return;
        }

        gThis._UpdateDatagridSelection(mValue.photos);
        gThis.SetValue(mValue);
    };

    gThis._UpdateDatagridSelection = function (mValue) {
        if (!(mValue instanceof Array)) {
            if ((mValue == undefined) || !mValue.length) {
                mValue = [];
            }
            else {
                mValue = [mValue];
            }
        }

        gThis.m_gFilesDatagrid.m_asSelected = [];
        for (var i = 0; i < mValue.length; i++) {
            gThis.m_gFilesDatagrid.m_asSelected[i] = mValue[i];
        }
        if (gThis.m_bShown) {
            gThis.m_gFilesDatagrid.LoadData();
        }
    };

    gThis._OnSelect = function (gDg, sId) {
        var oFile = gDg.GetRow(sId);
        gThis._AddImage(sId, oFile);
    };

    gThis._AddImage = function (sId, oFile) {

        if (gThis.m_bRepeatable) {
            var jFileTr = $('<tr class="file__' + sId + '"/>');
            jFileTr.append('<th scope="row"><span class="' + gThis._GetClass('Thumb') + '"><img src="' + oFile.preview + '" alt=""/></span><span class="' + gThis._GetClass('Name') + '">' + oFile.name + '</span></th>');
            var jRadio = $('<input type="radio" name="' + gThis.GetName() + '[main]" value="' + sId + '"/>');
            if (gThis.m_oOptions.asDefaults.main_photo) {

                if (!gThis.m_bLoadedDefaults) {
                    if (sId == gThis.m_oOptions.asDefaults.main_photo) {
                        jRadio.attr('checked', 'checked');
                    }
                }
                else {
                    if (sId == gThis.m_oOptions.asDefaults.main_photo) {
                        jRadio.attr('checked', 'checked');
                    }
                    if (!gThis.m_jSelectedFiles.children('tr').length) {
                        jRadio.attr('checked', 'checked');
                    }
                }
            }
            else if (!gThis.m_jSelectedFiles.children('tr').length) {
                jRadio.attr('checked', 'checked');
            }
            jFileTr.append($('<td/>').append(jRadio));
            var jRemove = $('<a href="#"/>');
            jRemove.click(function () {
                var sId = $(this).closest('tr').attr('class').substr(6);
                gThis.m_gFilesDatagrid.DeselectRow(sId);
                return false;
            });
            jRemove.append('<img src="' + gThis._GetImage('DeleteIcon') + '" alt="' + GForm.Language.file_selector_deselect + '" title="' + GForm.Language.file_selector_deselect + '"/>');
            jFileTr.append($('<td></td>').append(jRemove));
            gThis.m_jSelectedFiles.append(jFileTr);
        }
        else {
            var jRemove = $('<a href="#"/>');
            jRemove.click(function () {
                gThis.m_gFilesDatagrid.DeselectRow(sId);
                gThis.m_jSelectedFiles.empty();
                return false;
            });
            jRemove.append('<img src="' + gThis._GetImage('DeleteIcon') + '" alt="' + GForm.Language.file_selector_deselect + '" title="' + GForm.Language.file_selector_deselect + '"/>');
            gThis.m_jSelectedFiles.empty().append('<h4>' + GForm.Language.file_selector_selected_image + '</h4>').append('<img src="' + oFile.preview + '" alt=""/>').append(jRemove);
        }
    };

    gThis._OnDeselect = function (gDg, sId) {
        gThis._RemoveImage(sId);
    };

    gThis._RemoveImage = function (sId, oFile) {
        if (gThis.m_bRepeatable) {
            var bCheck = false;
            var jFileTr = gThis.m_jSelectedFiles.find('tr.file__' + sId);
            if (jFileTr.find('input[name="' + gThis.GetName() + '[main]"]:checked').length) {
                bCheck = true;
            }
            jFileTr.remove();
            if (bCheck) {
                gThis.m_jSelectedFiles.find('tr:first input[name="' + gThis.GetName() + '[main]"]').click();
            }
        }
        else {
            gThis.m_jSelectedFiles.empty();
        }
    };

    gThis._OnChange = function (iDg, asIds) {
        if (gThis.m_bRepeatable) {
            gThis.m_jField.empty();
        }
        gThis.SetValue(asIds);
    };

    gThis.OnReset = function () {
        gThis.m_bLoadedDefaults = false;
    };

    gThis.OnShow = function () {
        if (gThis.m_bShown === false) {
            gThis._InitFilesDatagrid();
            gThis._InitUploader();
            if (gThis.m_bRepeatable) {
                gThis.Populate(gThis.m_oOptions.asDefaults);
            }
            else {
                gThis.Populate(gThis.m_oOptions.sDefault);
            }
            gThis.m_bShown = true;
            gThis.m_jUnmodified.val('0');
        }
    };

    gThis._ProcessFile = function (oRow) {
        if (oRow.thumb != '') {
            oRow.preview = '<a href="' + oRow.preview + '" ><img src="' + oRow.preview + '" style="vertical-align: middle;" alt="' + GForm.Language.file_selector_show_thumb + '"/></a>';
        }
        return oRow;
    };

    gThis._InitUploader = function () {
        var uploader = new plupload.Uploader({
            runtimes: 'html5',
            browse_button: gThis.GetId() + '__upload',
            container: document.getElementById(gThis.GetId() + '__queue'),
            url: gThis.m_oOptions.sUploadUrl,
            filters: {
                max_file_size: '10mb',
                mime_types: [{
                    title: "Image files",
                    extensions: "jpg,jpeg,gif,png"
                }]
            },
            init: {
                FilesAdded: function (up, files) {
                    plupload.each(files, function (file) {
                        gThis.OnFileQueued(file);
                    });
                    up.start();
                },
                FileUploaded: function (up, files, response) {
                    gThis.OnUploadSuccess(files, response);
                },
                UploadProgress: function (up, file) {
                    gThis.OnUploadProgress(file);
                },
                Error: function (up, err) {
                    gThis.OnUploadProgress(err);
                },
                UploadComplete: function () {
                    gThis.OnUploadComplete();
                }
            }
        });

        uploader.init();
    };

    gThis.OnFileQueued = function (oFile) {
        if (gThis.m_iUploadsInProgress++ == 0) {
            gThis.m_iLockId = gThis.m_gForm.Lock(GForm.Language.file_selector_form_blocked, GForm.Language.file_selector_form_blocked_description);
        }
        var jLi = $('<li class="upload__' + oFile.id + '"/>');
        jLi.append('<h4>' + oFile.name + '</h4>');
        jLi.append('<p class="' + gThis._GetClass('Progress') + '"/>');
        jLi.append('<div class="' + gThis._GetClass('ProgressBar') + '"><div class="' + gThis._GetClass('ProgressBarIndicator') + '"></div>');
        gThis.m_jQueue.append(jLi);
    };

    gThis.OnDelete = function () {
        gThis.m_jSwfUpload.swfupload('cancelUpload', sFid);
    };

    gThis.OnUploadProgress = function (oFile) {
        var jLi = gThis.m_jQueue.find('.upload__' + oFile.id);
        jLi.find('.' + gThis._GetClass('Progress')).text(oFile.percent + '%');
        jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', oFile.percent + '%');
    };

    gThis.OnUploadError = function (oError) {
        GAlert(GForm.Language.file_selector_upload_error, oError.message);
    };

    gThis.OnUploadSuccess = function (oFile, oResponse) {
        var oServerResponse = $.parseJSON(oResponse.response);
        if (oServerResponse.sError != undefined) {
            return GAlert(oServerResponse.sError, oServerResponse.sMessage);
        }
        var jLi = gThis.m_jQueue.find('.upload__' + oFile.id);
        jLi.addClass(gThis._GetClass('UploadSuccess'));
        jLi.find('.' + gThis._GetClass('Progress')).text(GForm.Language.file_selector_upload_success);
        jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', '100%');
        if ((gThis.m_oOptions.oRepeat.iMax == 1) || !(gThis.m_gFilesDatagrid.m_asSelected instanceof Array)) {
            gThis.m_gFilesDatagrid.m_asSelected = [];
        }
        gThis.m_gFilesDatagrid.m_asSelected.push(oServerResponse.sId);
        gThis._OnChange(0, gThis.m_gFilesDatagrid.m_asSelected);
        gThis._AddImage(oServerResponse.sId, {
            id: oServerResponse.sId,
            name: oServerResponse.sFilename,
            preview: oServerResponse.sThumb,
            type: oServerResponse.sFileType,
            extension: oServerResponse.sExtension
        });
        gThis.m_gFilesDatagrid.LoadData();
        jLi.delay(2000).fadeOut(250, function () {
            $(this).remove();
        });
    };

    gThis.OnUploadComplete = function () {
        if (--gThis.m_iUploadsInProgress <= 0) {
            gThis.m_iUploadsInProgress = 0;
            gThis.m_gForm.Unlock(gThis.m_iLockId);
        }
    };

    gThis._InitColumns = function () {

        var column_id = new GF_Datagrid_Column({
            id: 'id',
            caption: GForm.Language.file_selector_id,
            sorting: {
                default_order: GF_Datagrid.SORT_DIR_DESC
            },
            appearance: {
                width: 90,
                visible: false
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_name = new GF_Datagrid_Column({
            id: 'name',
            caption: GForm.Language.file_selector_filename,
            filter: {
                type: GF_Datagrid.FILTER_INPUT
            }

        });

        var column_extension = new GF_Datagrid_Column({
            id: 'extension',
            caption: GForm.Language.file_selector_extension
        });

        var column_thumb = new GF_Datagrid_Column({
            id: 'preview',
            caption: GForm.Language.file_selector_thumb,
            appearance: {
                width: 30,
                no_title: true
            }
        });

        return [
            column_id,
            column_thumb,
            column_name,
            column_extension,
        ];

    };

    gThis._LoadDefaults = function (oRequest) {
        gThis.m_jSelectedFiles.empty();

        if (gThis.m_bRepeatable) {
            oRequest.where = [{
                column: 'id',
                value: gThis.m_oOptions.asDefaults.photos,
                operator: 'IN'
            }];
        }
        else {
            oRequest.where = [{
                column: 'id',
                value: gThis.m_oOptions.sDefault,
                operator: 'IN'
            }];
        }
        oRequest.id = 0;
        oRequest.starting_from = 0;
        oRequest.limit = gThis.m_oOptions.iLimit;
        oRequest.order_by = 'id';
        oRequest.order_dir = 'desc';
        gThis.LoadFiles(oRequest);
    };

    gThis.LoadFiles = function (oRequest) {
        gThis.m_gFilesDatagrid.MakeRequest(gThis.m_oOptions.sLoadRoute, oRequest, gThis._DefaultsLoaded);
    };

    gThis._DefaultsLoaded = function (oData) {
        for (var i = 0; i < oData.rows.length; i++) {
            gThis._AddImage(oData.rows[i].id, oData.rows[i]);
        }
        gThis.m_bLoadedDefaults = true;
    };

    gThis._OnDataLoaded = function (dDg) {
        dDg.m_jBody.find('.show-thumb').mouseenter(GTooltip.ShowThumbForThis).mouseleave(GTooltip.HideThumbForThis);
    };

    gThis._InitFilesDatagrid = function () {

        var aoColumns = gThis._InitColumns();

        var oOptions = {
            id: gThis.GetId(),
            mechanics: {
                rows_per_page: 15,
                key: 'id',
                only_one_selected: !gThis.m_bRepeatable,
                no_column_modification: true,
                persistent: false
            },
            event_handlers: {
                load: function (oRequest, sResponseHandler) {
                    if (!gThis.m_bLoadedDefaults) {
                        gThis._LoadDefaults(GCore.Duplicate(true, oRequest));
                        gThis.m_bLoadedDefaults = true;
                    }
                    gThis.m_gFilesDatagrid.MakeRequest(gThis.m_oOptions.sLoadRoute, oRequest, GF_Datagrid.ProcessIncomingData);
                },
                loaded: gThis._OnDataLoaded,
                process: gThis._ProcessFile,
                select: gThis._OnSelect,
                deselect: gThis._OnDeselect,
                selection_changed: gThis._OnChange
            },
            columns: aoColumns
        };

        gThis.m_gFilesDatagrid = new GF_Datagrid(gThis.m_jFilesDatagrid, oOptions);
    };

}, oDefaults);