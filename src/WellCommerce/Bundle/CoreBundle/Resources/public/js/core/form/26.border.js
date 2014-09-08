/*
* BORDER
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-border',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-field-repetition',
		sRemoveRepetitionClass: 'remove-field-repetition',
		sColourTypeClass: 'colour-type',
		sColourStartClass: 'colour-start',
		sColourEndClass: 'colour-end',
		sColourPreviewClass: 'colour-preview'
	},
	oImages: {
		sBold: 'images/icons/font-style-bold.png',
		sUnderline: 'images/icons/font-style-underline.png',
		sItalic: 'images/icons/font-style-italic.png',
		sAddRepetition: 'images/icons/buttons/add.png',
		sRemoveRepetition: 'images/icons/buttons/delete.png',
		sSideAll: 'images/icons/buttons/border-all.png',
		sSide_top: 'images/icons/buttons/border-top.png',
		sSide_right: 'images/icons/buttons/border-right.png',
		sSide_bottom: 'images/icons/buttons/border-bottom.png',
		sSide_left: 'images/icons/buttons/border-left.png'
	},
	sFieldType: 'text',
	sDefault: '',
	aoRules: [],
	sComment: '',
	sSelector: ''
};

var GFormBorder = GCore.ExtendClass(GFormTextField, function() {
	
	var gThis = this;
	
	gThis.m_oSides = {};
	gThis.m_oSizeField = {};
	gThis.m_oColourField = {};
	gThis.m_oColourPreviewFields = {};
	
	gThis.m_jGlobalSide;
	gThis.m_jSeparationTrigger;
	
	gThis.m_bSeparated = false;
	
	gThis.m_fOnUpdate = GCore.NULL;
	
	gThis.m_asSides = ['top', 'right', 'bottom', 'left'];
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label for="' + gThis.GetId() + '"/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
				jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jLabel = jLabel;
		gThis.m_jNode.append(jLabel);
		gThis.m_jNode.append(gThis._AddField());
		for (var i = 0; i < gThis.m_asSides.length; i++) {
			gThis.m_jNode.append(gThis._AddSideOptions(gThis.m_asSides[i]));
		}
		if ((gThis.m_oOptions.sSelector != undefined) && (gThis.m_oOptions.sSelector.length)) {
			gThis.m_jNode.append('<input type="hidden" name="' + gThis.GetName() + '[selector]" value="' + gThis.m_oOptions.sSelector + '"/>');
		}
		gThis.SetValue({});
	};
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		return gThis.m_jField.eq(0).val();
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (mValue == undefined) {
			return;
		}
		var bSeparate = false;
		for (var i in gThis.m_asSides) {
			var sSide = gThis.m_asSides[i];
			var sColour;
			var sSize;
			if (mValue[sSide] != undefined) {
				gThis.m_oColourField[sSide].val((mValue[sSide].colour == undefined) ? '000000' : mValue[sSide].colour);
				gThis.m_oSizeField[sSide].val((mValue[sSide].size == undefined) ? '1' : mValue[sSide].size).change();
			}
			else {
				gThis.m_oColourField[sSide].val('000000');
				gThis.m_oSizeField[sSide].val('1').change();
			}
			if (sColour == undefined) {
				sColour = gThis.m_oColourField[sSide].val();
			}
			else if (sColour != gThis.m_oColourField[sSide].val()) {
				bSeparate = true;
			}
			if (sSize == undefined) {
				sSize = gThis.m_oSizeField[sSide].val();
			}
			else if (sSize != gThis.m_oSizeField[sSide].val()) {
				bSeparate = true;
			}
		}
		gThis.UpdateSeparation(bSeparate);
	};
	
	gThis.UpdateSeparation = function(bSeparate) {
		gThis.m_bSeparated = bSeparate;
		if (bSeparate) {
			gThis.m_jSeparationTrigger.removeClass('active');
			gThis.m_jNode.find('.side').slideDown(250);
			gThis.m_jGlobalSide.find('.field:not(.icon)').css('display', 'none');
			gThis.m_oColourPreviewFields['all'].css('visibility', 'hidden');
		}
		else {
			gThis.m_jSeparationTrigger.addClass('active');
			gThis.m_oColourField['all'].val(gThis.m_oColourField['top'].val()).change();
			gThis.m_oSizeField['all'].val(gThis.m_oSizeField['top'].val()).change();
			gThis.m_jNode.find('.side').css('display', 'none');
			gThis.m_jGlobalSide.find('.field:not(.icon)').css('display', 'inline');
			gThis.m_oColourPreviewFields['all'].css('visibility', 'visible');
		}
		gThis.UpdatePreview();
	};

	gThis.UpdatePreview = function(sSide) {
		for (var i in gThis.m_oColourField) {
			gThis.m_oColourPreviewFields[i].css('background-color', '#' + gThis.m_oColourField[i].val());
		}
		if (gThis.m_bSeparated) {
			gThis.m_oColourPreviewFields['all'].css('background-color', 'transparent').parent().addClass('none');
		}
		else {
			gThis.m_oColourPreviewFields['all'].parent().removeClass('none');
		}
		if (gThis.m_fOnUpdate instanceof Function) {
			gThis.m_fOnUpdate.apply(gThis, [{}]);
		}
	};
	
	gThis._AddSideOptions = function(sSide) {
		var jSide = $('<div class="side"/>');
		
		var jColourPreviewNode = $('<span class="' + gThis._GetClass('ColourPreview') + '"/>');
		
		var jSizeField = $('<select name="' + gThis.GetName() + '[' + sSide + '][size]" />');
		jSizeField.append('<option value="0">' + GForm.Language.border_none + '</option>');
		for (var i = 1; i < 5; i++) {
			jSizeField.append('<option value="' + i + '">' + i + ' px</option>');
		};
		
		var jColourField = $('<input type="text" name="' + gThis.GetName() + '[' + sSide + '][colour]" />');
		
		jSide.append('<label>' + GForm.Language['border_side_' + sSide] + '</label>');
		var jRepetition = $('<span class="repetition"/>');
		//jRepetition.append(jColourPreviewNode);
		jRepetition.append($('<span class="' + gThis._GetClass('ColourPreview') + '-container"/>').append(jColourPreviewNode));
		jRepetition.append('<span class="field icon"><img src="' + gThis._GetImage('Side_' + sSide) + '" alt="' + GForm.Language['border_side_' + sSide] + '"/></span>');
		jRepetition.append($('<span class="field size"/>').append(jSizeField));
		jRepetition.append($('<span class="field colour"/>').append(jColourField));
		jSide.append(jRepetition);
		
		gThis.m_oSides[sSide] = jSide;
		gThis.m_oSizeField[sSide] = jSizeField;
		gThis.m_oColourField[sSide] = jColourField;
		gThis.m_oColourPreviewFields[sSide] = jColourPreviewNode;
		return jSide;
	};
	
	gThis._AddField = function(sId) {
		
		var jSide = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		gThis.m_jGlobalSide = jSide;
		
		var jColourPreviewNode = $('<span class="' + gThis._GetClass('ColourPreview') + '"/>');
		
		var jSizeField = $('<select/>');
		jSizeField.append('<option value="0">' + GForm.Language.border_none + '</option>');
		for (var i = 1; i < 5; i++) {
			jSizeField.append('<option value="' + i + '">' + i + ' px</option>');
		};
		
		var jColourField = $('<input type="text"/>');
		
		//jSide.append(jColourPreviewNode);
		jSide.append($('<span class="' + gThis._GetClass('ColourPreview') + '-container"/>').append(jColourPreviewNode));
		
		gThis.m_jSeparationTrigger = $('<span class="field icon"><img src="' + gThis._GetImage('SideAll') + '" alt="' + GForm.Language['border_separate'] + '" title="' + GForm.Language['border_separate'] + '"/></span>');
		jSide.append(gThis.m_jSeparationTrigger);
		jSide.append($('<span class="field size"/>').append(jSizeField));
		jSide.append($('<span class="field colour"/>').append(jColourField));
		
		gThis.m_oSides['all'] = jSide;
		gThis.m_oSizeField['all'] = jSizeField;
		gThis.m_oColourField['all'] = jColourField;
		gThis.m_oColourPreviewFields['all'] = jColourPreviewNode;
	
		return jSide;
	};
	
	gThis.OnShow = function() {
		if (gThis.m_bShown) {
			return;
		}
		gThis.m_bShown = true;
		for (var i in gThis.m_oSizeField) {
			gThis.m_oSizeField[i].GSelect();
		}
	};
	
	gThis._Initialize = function() {
		gThis.UpdatePreview();
	};
	
	gThis._InitializeEvents = function() {
		
		gThis.m_jSeparationTrigger.css('cursor', 'pointer').click(GEventHandler(function(eEvent) {
			gThis.UpdateSeparation(!gThis.m_bSeparated);
		}));
		
		for (var i in gThis.m_oColourField) {
			gThis.m_oColourField[i].ColorPicker({
				color: '#' + gThis.m_oColourField[i].val(),
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				},
				onShow: function(colpkr) {
					$(colpkr).fadeIn(250);
					$(this).closest('.field').addClass('focus');
					$(colpkr).data('field', $(this));
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(250);
					$(colpkr).data('field').triggerHandler('change');
					$(colpkr).data('field').closest('.field').removeClass('focus');
					return false;
				},
				onChange: function(hsb, hex, rgb) {
					$(this).data('field').val(hex);
					$(this).data('field').closest('.side, .repetition').find('.colour-preview').css('background-color', '#' + hex);
				}
			}).change(GEventHandler(function(eEvent) {
				gThis.UpdatePreview();
			}));
			gThis.m_oSizeField[i].change(GEventHandler(function(eEvent) {
				gThis.UpdatePreview();
			})).triggerHandler('change');
		}
		
		gThis.m_oColourField['all'].change(GEventHandler(function() {
			var sValue = $(this).val();
			for (var i in gThis.m_oColourField) {
				gThis.m_oColourPreviewFields[i].css('background-color', '#' + sValue);
				gThis.m_oColourField[i].val(sValue);
			}
			gThis.m_oColourField['top'].change();
		}));
		
		gThis.m_oSizeField['all'].change(GEventHandler(function() {
			var sValue = $(this).val();
			for (var i in gThis.m_oSizeField) {
				if (i == 'all') {
					continue;
				}
				gThis.m_oColourPreviewFields[i].css('background-color', '#' + sValue);
				gThis.m_oSizeField[i].val(sValue).change();
			}
			if (!parseInt(sValue)) {
				gThis.m_oColourPreviewFields['all'].css('background-color', 'transparent').parent().addClass('none');
			}
			else {
				gThis.m_oColourPreviewFields['all'].parent().removeClass('none');
			}
		})).triggerHandler('change');
		
		for (var i in gThis.m_oSizeField) {
			if (i == 'all') {
				continue;
			}
			gThis.m_oSizeField[i].bind('change', {i: i}, GEventHandler(function(eEvent) {
				var sValue = $(this).val();
				if (!parseInt(sValue)) {
					gThis.m_oColourPreviewFields[eEvent.data.i].css('background-color', 'transparent').parent().addClass('none');
				}
				else {
					gThis.m_oColourPreviewFields[eEvent.data.i].parent().removeClass('none');
				}
			}));
		}
		
		gThis.m_oColourField['all'].change(GEventHandler(function() {
			var sValue = $(this).val();
			for (var i in gThis.m_oColourField) {
				if (i == 'all') {
					continue;
				}
				gThis.m_oColourPreviewFields[i].css('background-color', '#' + sValue);
				gThis.m_oColourField[i].val(sValue).change();
			}
		}));
	};

	gThis.Reset = function() {
		gThis.m_jField.eq(0).val(gThis.m_oOptions.sDefault).change();
	};
	
}, oDefaults);