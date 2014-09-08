/*
* DOWNLOADER
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
	aoRules: [],
	sComment: '',
	sUploadUrl: '',
	sSessionId: '',
	sSessionName: '',
	asFileTypes: [],
	sFileTypesDescription: '',
	fDeleteHandler: GCore.NULL,
	fLoadFiles: GCore.NULL,
	sSwfUploadUrl: '_data_panel/swfupload.swf',
	iWidth: 131,
	iHeight: 34,
	iMaxFileSize: 100 * 1024,	// kB
	sMainId: 0
};

var GFormDownloader = GCore.ExtendClass(GFormFile, function() {

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

	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label for="' + gThis.GetId() + '"/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
			jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jSwfUpload = $('<div class="' + gThis._GetClass('AddFiles') + '"/>').append('<span id="' + gThis.GetId() + '__upload"/>');
		gThis.m_jNode.append(gThis.m_jSwfUpload);
		gThis.m_jChooseButton = $('<a href="#" class="button expand"><span><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfiles_select + '</span></a>');
		gThis.m_jNode.append($('<span class="browse-pictures" style="float: right;margin-right: 5px;"/>').append(gThis.m_jChooseButton));
		gThis.m_jQueue = $('<ul class="' + gThis._GetClass('Queue') + '"/>');
		gThis.m_jNode.append(gThis.m_jQueue);
		gThis.m_jFilesDatagrid = $('<div/>').css('display', 'none');
		gThis.m_jNode.append(gThis.m_jFilesDatagrid);
		if (gThis.m_bRepeatable) {
			var jTable = $('<table class="' + gThis._GetClass('SelectedTable') + '" cellspacing="0"/>');
			var jThead = $('<thead/>');
			jThead.append('<th>' + GForm.Language.file_selector_selected_image + '</th>');
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

	gThis._InitializeEvents = function() {
		gThis.m_jChooseButton.click(gThis._OnChoose);
	};
	
	gThis._OnChoose = GEventHandler(function(eEvent) {
		gThis.m_jFilesDatagrid.slideToggle(250);
		gThis.m_jChooseButton.toggleClass('expand');
		if(gThis.m_jChooseButton.hasClass('expand')){
			gThis.m_jChooseButton.find('span').html('<img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_select);
		}else{
			gThis.m_jChooseButton.find('span').html('<img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_unselect);
		}
		return false;
	});
	
	gThis.GetValue = function(sRepetition) {
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

	gThis.SetValue = function(mValue, sRepetition) {
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
	
	gThis.Populate = function(mValue) {
		if (!gThis.m_gFilesDatagrid) {
			return;
		}
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
			gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
		}
		else {
			gThis.m_oOptions.sDefault = mValue;
		}
		gThis._UpdateDatagridSelection(mValue);
		gThis.SetValue(mValue);
	};
	
	gThis._UpdateDatagridSelection = function(mValue) {
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

	gThis._OnSelect = function(gDg, sId) {
		var oFile = gDg.GetRow(sId);
		gThis._AddImage(sId, oFile);
	};
	
	gThis._AddImage = function(sId, oFile) {
		if (gThis.m_bRepeatable) {
			var jFileTr = $('<tr class="file__' + sId + '"/>');
			jFileTr.append('<th scope="row"><span class="' + gThis._GetClass('Name') + '">' + oFile.filename + '</span></th>');
			var jRemove = $('<a href="#"/>');
			jRemove.click(function() {
				var sId = $(this).closest('tr').attr('class').substr(6);
				gThis.m_gFilesDatagrid.DeselectRow(sId);
				return false;
			});
			jRemove.append('<img src="' + gThis._GetImage('DeleteIcon') + '" alt="' + GForm.Language.file_selector_deselect + '" title="' + GForm.Language.file_selector_deselect + '"/>');
			jFileTr.append($('<td></td>').append(jRemove));
			gThis.m_jSelectedFiles.append(jFileTr);
		}
		else {
			gThis.m_jSelectedFiles.empty().append('<h4>' + GForm.Language.file_selector_selected_image + '</h4>').append('<img src="' + oFile.thumb + '" alt=""/>');
		}
	};

	gThis._OnDeselect = function(gDg, sId) {
		gThis._RemoveImage(sId);
	};
	
	gThis._RemoveImage = function(sId, oFile) {
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

	gThis._OnChange = function(iDg, asIds) {
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
		}
		gThis.SetValue(asIds);
	};
	
	gThis.OnReset = function() {
		gThis.m_bLoadedDefaults = false;
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
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

	gThis._ProcessFile = function(oRow) {
		if (oRow.thumb != '') {
			oRow.thumbpreview = '<a href="' + oRow.thumb + '" class="show-thumb"><img src="' + GCore.DESIGN_PATH + 'images/icons/datagrid/details.png" style="vertical-align: middle;" alt="' + GForm.Language.file_selector_show_thumb + '"/></a>';
		}
		return oRow;
	};

	gThis._InitUploader = function() {
		var sFileTypes = '';
		for (var i = 0; i < gThis.m_oOptions.asFileTypes.length; i++) {
			sFileTypes += '; *.' + gThis.m_oOptions.asFileTypes[i];
		}
		sFileTypes = sFileTypes.substr(2);
		var oPostParams = {};
		oPostParams[gThis.m_oOptions.sSessionName] = gThis.m_oOptions.sSessionId;
		gThis.m_jSwfUpload.swfupload({
			upload_url: gThis.m_oOptions.sUploadUrl,
			file_size_limit: gThis.m_oOptions.iMaxFileSize,
			file_types: sFileTypes,
			file_types_description: gThis.m_oOptions.sFileTypesDescription,
			file_upload_limit: 0,
			file_queue_limit: 0,
			button_image_url: gThis._GetImage('UploadButton'),
			button_placeholder_id: gThis.GetId() + '__upload',
			button_width: gThis.m_oOptions.iWidth,
			button_height: gThis.m_oOptions.iHeight,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			flash_url: GCore.DESIGN_PATH + gThis.m_oOptions.sSwfUploadUrl,
			post_params: oPostParams
		});
		gThis.m_jSwfUpload.bind("fileQueued", gThis.OnFileQueued);
		gThis.m_jSwfUpload.bind("uploadComplete", gThis.OnUploadComplete);
		gThis.m_jSwfUpload.bind("uploadSuccess", gThis.OnUploadSuccess);
		gThis.m_jSwfUpload.bind("uploadProgress", gThis.OnUploadProgress);
		gThis.m_jSwfUpload.bind("uploadError", gThis.OnUploadError);
	};

	gThis.OnFileQueued = function(eEvent, oFile) {
		if (gThis.m_iUploadsInProgress++ == 0) {
			gThis.m_iLockId = gThis.m_gForm.Lock(GForm.Language.file_selector_form_blocked, GForm.Language.file_selector_form_blocked_description);
		}
		gThis.m_jSwfUpload.swfupload("startUpload");
		var jLi = $('<li class="upload__' + oFile.index + '"/>');
		jLi.append('<h4>' + oFile.name + '</h4>');
		jLi.append('<p class="' + gThis._GetClass('Progress') + '"/>');
		jLi.append('<div class="' + gThis._GetClass('ProgressBar') + '"><div class="' + gThis._GetClass('ProgressBarIndicator') + '"></div>');
		gThis.m_jQueue.append(jLi);
	};

	gThis.OnDelete = function() {
		gThis.m_jSwfUpload.swfupload('cancelUpload', sFid);
	};

	gThis.OnUploadProgress = function(eEvent, oFile, iCompleted, iTotal) {
		var jLi = gThis.m_jQueue.find('.upload__' + oFile.index);
		var iPercentage = Math.round(iCompleted / iTotal * 100);
		jLi.find('.' + gThis._GetClass('Progress')).text(iPercentage + '%: ' + Math.ceil(iCompleted / 1024) + 'kB / ' + Math.ceil(iTotal / 1024) + 'kB');
		jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', (iCompleted / iTotal * 100) + '%');
	};

	gThis.OnUploadError = function(eEvent, oFile, iErrorCode, sMessage) {
		var jLi = gThis.m_jQueue.find('.upload__' + oFile.index);
		jLi.addClass(gThis._GetClass('UploadError'));
		jLi.find('.' + gThis._GetClass('Progress')).text(GForm.Language.file_selector_upload_error);
		jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', '100%');
		GAlert(GForm.Language.file_selector_upload_error, sMessage);
		jLi.delay(2000).fadeOut(250, function() {
			$(this).remove();
		});
	};

	gThis.OnUploadSuccess = function(eEvent, oFile, sServerData, sResponse) {
		if (sServerData.substr(0, 11) != 'response = ') {
			gThis.OnUploadError(eEvent, oFile, 0, sServerData);
			return;
		}
		var jLi = gThis.m_jQueue.find('.upload__' + oFile.index);
		jLi.addClass(gThis._GetClass('UploadSuccess'));
		jLi.find('.' + gThis._GetClass('Progress')).text(GForm.Language.file_selector_upload_success);
		jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', '100%');
		eval("var oResponse = " + sServerData.substr(11) + ";");
		if (!oResponse.sId) {
			gThis.OnUploadError(eEvent, oFile, 0, GForm.Language.file_selector_processing_error);
			return;
		}
		if ((gThis.m_oOptions.oRepeat.iMax == 1) || !(gThis.m_gFilesDatagrid.m_asSelected instanceof Array)) {
			gThis.m_gFilesDatagrid.m_asSelected = [];
		}
		gThis.m_gFilesDatagrid.m_asSelected.push(oResponse.sId);
		gThis._OnChange(0, gThis.m_gFilesDatagrid.m_asSelected);
		gThis._AddImage(oResponse.sId, {
			idfile: oResponse.sId,
			filename: oResponse.sFilename,
			thumb: oResponse.sThumb,
			filetype: oResponse.sFileType,
			fileextension: oResponse.sExtension
		});
		gThis.m_gFilesDatagrid.LoadData();
		jLi.delay(2000).fadeOut(250, function() {
			$(this).remove();
		});
	};

	gThis.OnUploadComplete = function(eEvent, oFile) {
		if (--gThis.m_iUploadsInProgress <= 0) {
			gThis.m_iUploadsInProgress = 0;
			gThis.m_gForm.Unlock(gThis.m_iLockId);
		}
	};

	gThis._InitColumns = function() {

	  var column_id = new GF_Datagrid_Column({
			id: 'idfile',
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

		var column_filename = new GF_Datagrid_Column({
			id: 'filename',
			caption: GForm.Language.file_selector_filename,
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}

		});

		var column_fileextension = new GF_Datagrid_Column({
			id: 'fileextension',
			appearance: {
				width: 110,
			},
			caption: GForm.Language.file_selector_extension,
		});

		return [
			column_id,
			column_filename,
			column_fileextension,
		];

	};
	
	gThis._LoadDefaults = function(oRequest) {
		gThis.m_jSelectedFiles.empty();
		if (gThis.m_bRepeatable) {
			oRequest.where = [{
				column: 'idfile',
				value: gThis.m_oOptions.asDefaults,
				operator: 'IN'
			}];
		}
		else {
			oRequest.where = [{
				column: 'idfile',
				value: gThis.m_oOptions.sDefault,
				operator: 'IN'
			}];
		}
		oRequest.starting_from = 0;
		gThis.m_oOptions.fLoadFiles(oRequest, GCallback(gThis._DefaultsLoaded));
	};
	
	gThis._DefaultsLoaded = function(oData) {
		for (var i = 0; i < oData.rows.length; i++) {
			gThis._AddImage(oData.rows[i].idfile, oData.rows[i]);
		}
		gThis.m_bLoadedDefaults = true;
	};
	
	gThis._OnDataLoaded = function(dDg) {
		dDg.m_jBody.find('.show-thumb').mouseenter(GTooltip.ShowThumbForThis).mouseleave(GTooltip.HideThumbForThis);
	};

	gThis._InitFilesDatagrid = function() {

		var aoColumns = gThis._InitColumns();

    var oOptions = {
			id: gThis.GetId(),
			mechanics: {
				rows_per_page: 15,
				key: 'idfile',
				no_column_modification: true,
				only_one_selected: !gThis.m_bRepeatable,
				persistent: false
			},
			event_handlers: {
				load: function(oRequest, sResponseHandler) {
					if (!gThis.m_bLoadedDefaults) {
						gThis._LoadDefaults(GCore.Duplicate(true, oRequest));
						gThis.m_bLoadedDefaults = true;
					}
					gThis.m_oOptions.fLoadFiles(oRequest, sResponseHandler);
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