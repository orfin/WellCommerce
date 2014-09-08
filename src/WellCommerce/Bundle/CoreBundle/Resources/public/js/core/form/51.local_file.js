/*
* LOCAL FILE
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

var GFormLocalFile = GCore.ExtendClass(GFormFile, function() {

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

	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label for="' + gThis.GetId() + '"/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
			jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jNode.append(jLabel);
		gThis.m_jNode.append(gThis._AddField());
		if ((gThis.m_oOptions.sSelector != undefined) && (gThis.m_oOptions.sSelector.length)) {
			gThis.m_jNode.append('<input type="hidden" name="' + gThis.GetName() + '[selector]" value="' + gThis.m_oOptions.sSelector + '"/>');
		}
	};
	
	gThis._AddField = function() {
		var jRepetition = $('<span class="repetition"/>');
		gThis.m_jSelectedFileName = $('<span class="filename"/>');
		jRepetition.append(gThis.m_jSelectedFileName);
		gThis.m_jSwfUpload = $('<div class="' + gThis._GetClass('AddFiles') + '"><a href="#" class="button expand"><span id="' + gThis.GetId() + '__upload"><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfiles_upload + '</span></a></div>');
		jRepetition.append(gThis.m_jSwfUpload);
		gThis.m_jChooseButton = $('<a href="#" class="button expand"><span><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_select + '</span></a>');
		jRepetition.append($('<span class="browse-pictures"/>').append(gThis.m_jChooseButton));
		gThis.m_jQueue = $('<ul class="' + gThis._GetClass('Queue') + '" id="' + gThis.GetId() + '__queue"/>');
		jRepetition.append(gThis.m_jQueue);
		gThis.m_jFilesDatagrid = $('<div/>');
		jRepetition.append(gThis.m_jFilesDatagrid);
		gThis.m_jSelectedFiles = $('<div class="' + gThis._GetClass('SelectedTable') + '"/>');
		jRepetition.append(gThis.m_jSelectedFiles);
		gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '[file]"/>');
		jRepetition.append(gThis.m_jField);
		return jRepetition;
	};
	
	gThis._OnChoose = GEventHandler(function(eEvent) {
		if (!gThis.m_gFilesDatagrid) {
			gThis._InitFilesDatagrid();
			gThis.m_jFilesDatagrid.slideDown(250);
		}else{
			gThis.m_jFilesDatagrid.slideDown(250);
		}
		
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
			return {};
		}
		return {
			file: gThis.m_jField.val()
		};
	};

	gThis.SetValue = function(mValue, sRepetition) {
		if (mValue == undefined) {
			return;
		}
		if (gThis.m_jField == undefined) {
			return;
		}
		if (mValue['file'] == undefined) {
			gThis.m_jField.val('');
			gThis.m_jSelectedFileName.html('<span class="none">' + GForm.Language.localfile_none_selected + '</span>');
		}
		else {
			gThis.m_jField.val(mValue['file']).change();
			gThis.m_jSelectedFileName.text(mValue['file']);
			if (gThis.m_gFilesDatagrid) {
				gThis.m_gFilesDatagrid.m_asSelected = [gThis.m_oOptions.sFilePath + mValue['file']];
			}
		}
	};
	
	gThis.Populate = function(mValue) {
		if (gThis.m_gFilesDatagrid) {
			gThis._UpdateDatagridSelection(mValue['file']);
		}
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

	gThis._OnClickRow = function(gDg, sId) {
		var oFile = gThis.m_gFilesDatagrid.GetRow(sId);
		if (oFile.dir) {
			if (oFile.name == '..') {
				gThis.m_sCWD = gThis.m_sCWD.substr(0, gThis.m_sCWD.lastIndexOf('/', gThis.m_sCWD.length - 2));
			}
			else {
				gThis.m_sCWD += oFile.name + '/';
			}
			gThis.m_jSwfUpload.swfupload('addPostParam', 'path', gThis.m_sCWD);
			gThis._RefreshFiles();
			return false;
		}
		return true;
	};
	
	gThis._OnSelect = function(gDg, sId) {
		var oFile = gDg.GetRow(sId);
		if (!oFile.dir) {
			gThis.SetValue({
				file: oFile.path.substr(gThis.m_oOptions.sFilePath.length)
			});
		}
	};

	gThis._OnDeselect = function(gDg, sId) {
		gThis.SetValue('');
	};
	
	gThis._Initialize = function() {
		var oValue = gThis.GetValue();
		var sPath = gThis.m_oOptions.sFilePath + oValue.file;
		sPath = sPath.substr(0, sPath.lastIndexOf('/') + 1);
		gThis.m_sCWD = sPath;
	};
	
	gThis._InitializeEvents = function() {
		gThis.m_jChooseButton.click(gThis._OnChoose);
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
			gThis._InitUploader();
			gThis.m_bShown = true;
		}
	};

	gThis._ProcessFile = function(oRow) {
		if (oRow.dir) {
			if (oRow.name == '..') {
				oRow.thumbpreview = '<img src="' + gThis.m_oOptions.oTypeIcons['cdup'] + '" alt=""/>';
			}
			else {
				oRow.thumbpreview = '<img src="' + gThis.m_oOptions.oTypeIcons['directory'] + '" alt=""/>';
			}
		}
		else {
			var sExtension = oRow.name.substr(oRow.name.lastIndexOf('.') + 1);
			if (gThis.m_oOptions.oTypeIcons[sExtension] == undefined) {
				sExtension = 'unknown';
			}
			if ((sExtension == 'png') || (sExtension == 'jpg') || (sExtension == 'gif')) {
				oRow.thumbpreview = '<a href="' + GCore.DESIGN_PATH.substr(0, GCore.DESIGN_PATH.lastIndexOf('/', GCore.DESIGN_PATH.length - 2)) + '/' + oRow.path + '" class="show-thumb"><img src="' + gThis.m_oOptions.oTypeIcons[sExtension] + '" style="vertical-align: middle;" alt="' + GForm.Language.file_selector_show_thumb + '"/></a>';
			}
			else {
				oRow.thumbpreview = '<img src="' + gThis.m_oOptions.oTypeIcons[sExtension] + '" alt=""/>';
			}
		}
		return oRow;
	};

	gThis._InitUploader = function() {
		var uploader = new plupload.Uploader({
		    runtimes : 'html5',
		    browse_button : gThis.GetId() + '__upload',
		    container: document.getElementById(gThis.GetId() + '__queue'),
		    url : gThis.m_oOptions.sUploadUrl,
		    filters : {
		        max_file_size : '10mb',
		        mime_types: [{
		        	title : "Image files", 
		            extensions : gThis.m_oOptions.asFileTypes.join(',')
		        }]
		    },
		    init: {
		    	FilesAdded: function(up, files) {
		    		plupload.each(files, function(file) {
		    			gThis.OnFileQueued(file);
		    		});
		    		up.start();
		    	},
		    	FileUploaded: function(up, files, response) {
		    		gThis.OnUploadSuccess(files, response);
		        },
		        UploadProgress: function(up, file) {
		        	gThis.OnUploadProgress(file);
		        },
		 
		        Error: function(up, err) {
		        	gThis.OnUploadProgress(err);
		        },
		        UploadComplete: function(){
		        	gThis.OnUploadComplete();
		        }
		    }
		});
		 
		uploader.init();
	};

	gThis.OnFileQueued = function(oFile) {
		if (gThis.m_iUploadsInProgress++ == 0) {
			gThis.m_iLockId = gThis.m_gForm.Lock(GForm.Language.file_selector_form_blocked, GForm.Language.file_selector_form_blocked_description);
		}
		var jLi = $('<li class="upload__' + oFile.id + '"/>');
		jLi.append('<h4>' + oFile.name + '</h4>');
		jLi.append('<p class="' + gThis._GetClass('Progress') + '"/>');
		jLi.append('<div class="' + gThis._GetClass('ProgressBar') + '"><div class="' + gThis._GetClass('ProgressBarIndicator') + '"></div>');
		gThis.m_jQueue.append(jLi);
	};

	gThis.OnDelete = function() {
		gThis.m_jSwfUpload.swfupload('cancelUpload', sFid);
	};

	gThis.OnUploadProgress = function(oFile) {
		var jLi = gThis.m_jQueue.find('.upload__' + oFile.id);
		jLi.find('.' + gThis._GetClass('Progress')).text(oFile.percent + '%');
		jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', oFile.percent + '%');
	};

	gThis.OnUploadError = function(oError) {
		GAlert(GForm.Language.file_selector_upload_error, oError.message);
	};

	gThis.OnUploadSuccess = function(oFile, oResponse) {
		var oServerResponse = $.parseJSON(oResponse.response);
		var jLi = gThis.m_jQueue.find('.upload__' + oFile.id);
		jLi.addClass(gThis._GetClass('UploadSuccess'));
		jLi.find('.' + gThis._GetClass('Progress')).text(GForm.Language.file_selector_upload_success);
		jLi.find('.' + gThis._GetClass('ProgressBarIndicator')).css('width', '100%');
		gThis.SetValue({
			file: (gThis.m_sCWD + oResponse.sFilename).substr(gThis.m_oOptions.sFilePath.length)
		});
		gThis._RefreshFiles();
		if (gThis.m_gFilesDatagrid) {
			gThis.m_gFilesDatagrid.LoadData();
		}
		jLi.delay(2000).fadeOut(250, function() {
			$(this).remove();
		});
	};
	
	gThis.OnUploadComplete = function() {
		if (--gThis.m_iUploadsInProgress <= 0) {
			gThis.m_iUploadsInProgress = 0;
			gThis.m_gForm.Unlock(gThis.m_iLockId);
		}
	};

	gThis._InitColumns = function() {

	  var column_path = new GF_Datagrid_Column({
			id: 'path',
			caption: GForm.Language.localfile_fullpath,
			appearance: {
				width: 70,
				visible: false,
				align: GF_Datagrid.ALIGN_LEFT
			}
		});
		
		var column_thumb = new GF_Datagrid_Column({
			id: 'thumbpreview',
			caption: GForm.Language.file_selector_thumb,
			appearance: {
				width: 30,
				no_title: true
			}
		});

		var column_name = new GF_Datagrid_Column({
			id: 'name',
			caption: GForm.Language.localfile_filename,
			appearance: {
				width: 150,
				align: GF_Datagrid.ALIGN_LEFT
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});

		var column_size = new GF_Datagrid_Column({
			id: 'size',
			appearance: {
				width: 65,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			caption: GForm.Language.localfile_filesize
		});

		var column_mtime = new GF_Datagrid_Column({
			id: 'mtime',
			appearance: {
				width: 120,
				visible: false
			},
			caption: GForm.Language.localfile_filemtime
		});

		var column_owner = new GF_Datagrid_Column({
			id: 'owner',
			appearance: {
				width: 70,
				visible: false
			},
			caption: GForm.Language.localfile_fileowner
		});

		return [
			column_path,
			column_thumb,
			column_name,
			column_size,
			column_mtime,
			column_owner
		];

	};
	
	gThis._RefreshFiles = function() {
		gThis.m_oOptions.fLoadFiles({
			path: gThis.m_sCWD
		}, GCallback(gThis._OnFilesLoaded));
	};
	
	gThis._OnFilesLoaded = GEventHandler(function(eEvent) {
		if ((eEvent == undefined) || (eEvent.files == undefined) || (eEvent.cwd == undefined)) {
			return;
		}
		gThis.m_sCWD = eEvent.cwd;
		if (gThis.m_gDataProvider) {
			gThis.m_gDataProvider.ChangeData(eEvent.files);
			gThis.m_gFilesDatagrid.LoadData();
		}
	});

	gThis._Delete = function(iDg, sId) {
		var iAlertId = GWarning(GForm.Language.localfile_delete_warning, GForm.Language.localfile_delete_warning_description, {
			bAutoExpand: true,
			aoPossibilities: [
				{mLink: function() {
					GCore.StartWaiting();
					GAlert.Destroy(iAlertId);
					gThis.m_oOptions.fDeleteFile({
						file: sId
					}, GCallback(function(eEvent) {
						GCore.StopWaiting();
						var oValue = gThis.GetValue();
						if (sId == gThis.m_oOptions.sFilePath + oValue.file) {
							gThis.m_gFilesDatagrid.ClearSelection();
						}
						gThis._RefreshFiles();
					}));
				}, sCaption: GForm.Language.localfile_ok},
				{mLink: GAlert.DestroyThis, sCaption: GForm.Language.localfile_cancel}
			]
		});
	};
	
	gThis._OnDataLoaded = function(dDg) {
		dDg.m_jBody.find('.show-thumb').mouseenter(GTooltip.ShowThumbForThis).mouseleave(GTooltip.HideThumbForThis);
	};
	
	gThis._InitFilesDatagrid = function() {

		var aoColumns = gThis._InitColumns();
		
		gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
			key: 'path'
		}, []);
		
		var gActionDelete = new GF_Action({
			img: gThis._GetImage('DeleteIcon'),
			caption: GForm.Language.localfile_delete,
			action: gThis._Delete,
			condition: function(oRow) {
				return !oRow.dir;
			}
		});

    var oOptions = {
			id: gThis.GetId(),
			mechanics: {
				rows_per_page: 30,
				key: 'path',
				only_one_selected: true,
				no_column_modification: true,
				persistent: false
			},
			event_handlers: {
				load: function(oRequest, sResponseHandler) {
					return gThis.m_gDataProvider.Load(oRequest, sResponseHandler);
				},
				loaded: gThis._OnDataLoaded,
				process: gThis._ProcessFile,
				select: gThis._OnSelect,
				deselect: gThis._OnDeselect,
				click_row: gThis._OnClickRow
			},
			row_actions: [
				gActionDelete
			],
			columns: aoColumns
    };

		gThis.m_gFilesDatagrid = new GF_Datagrid(gThis.m_jFilesDatagrid, oOptions);
		
		var oValue = gThis.GetValue();
		var sFile = oValue.file;
		if (sFile != '') {
			gThis.m_gFilesDatagrid.m_asSelected = [gThis.m_oOptions.sFilePath + sFile];
		}
		
		gThis._RefreshFiles();
	};

}, oDefaults);