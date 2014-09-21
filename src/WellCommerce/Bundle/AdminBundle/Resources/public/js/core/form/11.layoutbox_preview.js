/*
* LAYOUT BOX SCHEME LIVE PREVIEW
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	sAlt: '',
	sSrc: '',
	oClasses: {
		sFieldClass: 'field-layout-box-scheme-preview'
	},
	sBoxName: '',
	sBoxScheme: '',
	sLayoutBoxTpl: '',
	sBoxTitle: 'Lorem Ipsum',
	sBoxContent: 'Lorem ipsum dolor sit amet enim.'
};

var GFormLayoutBoxSchemePreview = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_oValues = {};
	gThis.m_jWindow;
	gThis.m_bWindowLoaded = false;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jWindow = $('<iframe src="' + GCore.DESIGN_PATH + '_data_frontend/blank.htm" id="' + gThis.GetId() + '__window" width="300" height="100"/>');
		gThis.m_jNode.append(gThis.m_jWindow);
		gThis.m_jUnmodified = $('<input type="hidden" name="' + gThis.GetName() + '[unmodified]" value="1"/>');
		gThis.m_jNode.append(gThis.m_jUnmodified);
	};
	
	gThis._BuildWindow = function() {
		gThis.m_bWindowLoaded = true;
		var sTpl = gThis.m_oOptions.sLayoutBoxTpl;
		var sBoxScheme = gThis.m_oOptions.sBoxScheme;
		if (sBoxScheme.length) {
			sBoxScheme = 'layout-box layout-box-scheme-' + sBoxScheme;
		}
		else {
			sBoxScheme = 'layout-box';
		}
		var sBoxId = gThis.m_oOptions.sBoxName;
		if (sBoxId.length) {
			sBoxId = 'layout-box-' + sBoxId;
		}
		sTpl = sTpl.replace(/\{{\ box.id \}}/, sBoxId);
		sTpl = sTpl.replace(/\{{\ box.schemeClass \}}/, sBoxScheme);
		sTpl = sTpl.replace(/\{{\ box.heading \}}/, gThis.m_oOptions.sBoxTitle);
		sTpl = sTpl.replace(/\{%\ block content \%}/, '<p>' + gThis.m_oOptions.sBoxContent + '</p>');
		sTpl = sTpl.replace(/\{%\ endblock \%}/, '');
		sTpl = sTpl.replace(/\{%\ block headerurl \%}/, '');
		sTpl = sTpl.replace(/\{%\ endblock \%}/, '');
		var jBox = $(sTpl);
		jBox.find('.layout-box-icons').prepend('<span class="layout-box-close layout-box-icon"/>');
		jBox.find('.layout-box-icons').prepend('<span class="layout-box-uncollapse layout-box-icon"/>');
		gThis.m_jWindow.contents().find('head').empty();
		for (var i = 0; i < gThis.m_oOptions.asStylesheets.length; i++) {
			gThis.m_jWindow.contents().find('head').append('<link rel="stylesheet" href="' + gThis.m_oOptions.asStylesheets[i] + '?id=' + Math.random() + '" type="text/css"/>');
		}
		gThis.m_jWindow.contents().find('body').css({
			padding: 0,
			margin: 0,
			background: 'transparent',
			width: 'auto',
			minWidth: 0
		}).html(jBox.wrap('<div/>').parent().html());
		gThis.Refresh();
	};
	
	gThis.OnShow = function() {
		if (gThis.m_bShown) {
			return;
		}
		gThis.m_bShown = true;
		gThis._BuildWindow();
		gThis.m_jWindow.load(gThis._BuildWindow);
		gThis.m_jUnmodified.val('0');
	};
	
	gThis._InitializeEvents = function() {
		for (var i in gThis.m_oOptions.asTriggers) {
			var gField = gThis.m_gForm.GetField(gThis.m_oOptions.asTriggers[i]);
			if (gField instanceof GFormColourSchemePicker) {
				gThis._ConnectColourSchemePicker(gField);
			}
			else if (gField instanceof GFormFontStyle) {
				gThis._ConnectFontStyle(gField);
			}
			else if (gField instanceof GFormBorder) {
				gThis._ConnectBorder(gField);
			}
			else if (gField instanceof GFormSelect) {
				gThis._ConnectSelect(gField);
			}
			else if (gField instanceof GFormLocalFile) {
				gThis._ConnectLocalFile(gField);
			}
			else if (gField instanceof GFormTextField) {
				gThis._ConnectTextField(gField);
			}
		}
		gThis.Update({});
	};
	
	gThis._ConnectColourSchemePicker = function(gField) {
		gField.m_jFieldColourType.change(gThis.Update);
		gField.m_jFieldColourStart.change(gThis.Update);
		gField.m_jFieldColourEnd.change(gThis.Update);
		gField.m_jFileField.change(gThis.Update);
	};
	
	gThis._ConnectFontStyle = function(gField) {
		gField.m_jFieldFontFamily.change(gThis.Update);
		gField.m_jFieldFontStyleBold.change(gThis.Update);
		gField.m_jFieldFontStyleUnderline.change(gThis.Update);
		gField.m_jFieldFontStyleItalic.change(gThis.Update);
		gField.m_jFieldFontStyleUppercase.change(gThis.Update);
		gField.m_jFieldFontColour.change(gThis.Update);
		gField.m_jFieldFontSize.change(gThis.Update);
	};
	
	gThis._ConnectBorder = function(gField) {
		gField.m_fOnUpdate = gThis.Update;
	};
	
	gThis._ConnectSelect = function(gField) {
		gField.m_jField.change(gThis.Update);
	};
	
	gThis._ConnectTextField = function(gField) {
		gField.m_jField.change(gThis.Update);
	};
	
	gThis._ConnectLocalFile = function(gField) {
		gField.m_jField.change(gThis.Update);
	};
	
	gThis.Update = GEventHandler(function(eEvent) {
		gThis.m_oValues = {};
		for (var i in gThis.m_oOptions.asTriggers) {
			var gField = gThis.m_gForm.GetField(gThis.m_oOptions.asTriggers[i]);
			if (gField instanceof GFormColourSchemePicker) {
				gThis._UpdateColourSchemePicker(gField);
			}
			else if (gField instanceof GFormFontStyle) {
				gThis._UpdateFontStyle(gField);
			}
			else if (gField instanceof GFormBorder) {
				gThis._UpdateBorder(gField);
			}
			else if (gField instanceof GFormSelect) {
				gThis._UpdateSelect(gField);
			}
			else if (gField instanceof GFormLocalFile) {
				gThis._UpdateLocalFile(gField);
			}
			else if (gField instanceof GFormTextField) {
				gThis._UpdateTextField(gField);
			}
		}
		gThis.Refresh();
	});
	
	gThis._UpdateColourSchemePicker = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		switch (gField.m_jFieldColourType.val()) {
			case '3':
				gThis.m_oValues[sSelector]['background-color'] = '#' + gField.m_jFieldColourStart.val();
				if (gField.m_jFileField.val().length) {
					gThis.m_oValues[sSelector]['background-image'] = 'url(\'' + GCore.DESIGN_PATH.substr(0, GCore.DESIGN_PATH.lastIndexOf('/', GCore.DESIGN_PATH.length - 2)) + '/' + gField.m_oOptions.sFilePath + gField.m_jFileField.val() + '\')';
					gThis.m_oValues[sSelector]['background-position'] = '0 0';
					gThis.m_oValues[sSelector]['background-repeat'] = 'repeat-x';
				}
				else {
					gThis.m_oValues[sSelector]['background-image'] = 'none';
				}
				break;
			case '2':
				gThis.m_oValues[sSelector]['background-gradient'] = '#' + gField.m_jFieldColourStart.val();
				gThis.m_oValues[sSelector]['background-color'] = '#' + gField.m_jFieldColourEnd.val();
				gThis.m_oValues[sSelector]['background-image'] = 'none';
				break;
			default:
				gThis.m_oValues[sSelector]['background-color'] = '#' + gField.m_jFieldColourStart.val();
				gThis.m_oValues[sSelector]['background-image'] = 'none';
		}
	};
	
	gThis._UpdateFontStyle = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		gThis.m_oValues[sSelector]['color'] = '#' + gField.m_jFieldFontColour.val();
		gThis.m_oValues[sSelector]['font-family'] = gField.m_jFieldFontFamily.val();
		gThis.m_oValues[sSelector]['font-weight'] = (gField.m_jFieldFontStyleBold.val() == '1') ? 'bold' : 'normal';
		gThis.m_oValues[sSelector]['font-style'] = (gField.m_jFieldFontStyleItalic.val() == '1') ? 'italic' : 'normal';
		gThis.m_oValues[sSelector]['text-decoration'] = (gField.m_jFieldFontStyleUnderline.val() == '1') ? 'underline' : 'none';
		gThis.m_oValues[sSelector]['text-transform'] = (gField.m_jFieldFontStyleUppercase.val() == '1') ? 'uppercase': 'none';
		gThis.m_oValues[sSelector]['font-size'] = gField.m_jFieldFontSize.val() + 'px';
	};
	
	gThis._UpdateBorder = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		var asSides = ['top', 'right', 'bottom', 'left'];
		for (var i in asSides) {
			var iSize = parseInt(gField.m_oSizeField[asSides[i]].val());
			if (iSize == 0) {
				gThis.m_oValues[sSelector]['border-' + asSides[i]] = 'none';
			}
			else {
				gThis.m_oValues[sSelector]['border-' + asSides[i]] = 'solid ' + iSize + 'px #' + gField.m_oColourField[asSides[i]].val();
			}
		}
	};
	
	gThis._UpdateSelect = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		var sAttribute = gField.m_oOptions.sCssAttribute;
		if ((sAttribute == undefined) || !sAttribute.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		switch (sAttribute) {
			case 'border-radius':
				if (gThis.m_oValues[sSelector + ' .layout-box-header'] == undefined) {
					gThis.m_oValues[sSelector + ' .layout-box-header'] = {};
				}
				if (gThis.m_oValues[sSelector + ' .layout-box-content'] == undefined) {
					gThis.m_oValues[sSelector + ' .layout-box-content'] = {};
				}
				var iNewValue = Math.max(0, parseInt(gField.m_jField.val()) - 1) + 'px';
				gThis.m_oValues[sSelector]['BorderRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector + ' .layout-box-header']['BorderTopLeftRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-header']['BorderTopRightRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['BorderBottomLeftRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['BorderBottomRightRadius'] = iNewValue;
				gThis.m_oValues[sSelector]['MozBorderRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector + ' .layout-box-header']['MozBorderRadiusTopleft'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-header']['MozBorderRadiusTopright'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['MozBorderRadiusBottomleft'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['MozBorderRadiusBottomright'] = iNewValue;
				gThis.m_oValues[sSelector]['WebkitBorderTopLeftRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector]['WebkitBorderTopRightRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector]['WebkitBorderBottomLeftRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector]['WebkitBorderBottomRightRadius'] = gField.m_jField.val();
				gThis.m_oValues[sSelector + ' .layout-box-header']['WebkitBorderTopLeftRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-header']['WebkitBorderTopRightRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['WebkitBorderBottomLeftRadius'] = iNewValue;
				gThis.m_oValues[sSelector + ' .layout-box-content']['WebkitBorderBottomRightRadius'] = iNewValue;
				break;
			default:
				gThis.m_oValues[sSelector][sAttribute] = gField.m_jField.val();
		}
	};
	
	gThis._UpdateTextField = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		var sAttribute = gField.m_oOptions.sCssAttribute;
		if ((sAttribute == undefined) || !sAttribute.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		switch (sAttribute) {
			case 'line-height':
				if (gThis.m_oValues[sSelector + ' .layout-box-icon'] == undefined) {
					gThis.m_oValues[sSelector + ' .layout-box-icon'] = {};
				}
				gThis.m_oValues[sSelector][sAttribute] = gField.m_jField.val() + 'px';
				gThis.m_oValues[sSelector]['height'] = gField.m_jField.val() + 'px';
				gThis.m_oValues[sSelector + ' .layout-box-icon']['height'] = gField.m_jField.val() + 'px';
				break;
			default:
				gThis.m_oValues[sSelector][sAttribute] = gField.m_jField.val();
		}
	};
	
	gThis._UpdateLocalFile = function(gField) {
		var sSelector = gField.m_oOptions.sSelector;
		if ((sSelector == undefined) || !sSelector.length) {
			return;
		}
		if (gThis.m_oValues[sSelector] == undefined) {
			gThis.m_oValues[sSelector] = {};
		}
		gThis.m_oValues[sSelector]['background'] = 'transparent url(\'' + GCore.DESIGN_PATH.substr(0, GCore.DESIGN_PATH.lastIndexOf('/', GCore.DESIGN_PATH.length - 2)) + '/' + 'design/_images_frontend/upload/' + gField.m_jField.val() + '\') center center no-repeat';
	};
	
	gThis.Refresh = function() {
		if (!gThis.m_bWindowLoaded) {
			return;
		}
		gThis.m_jWindow.contents().find('body [style]').attr('style', '');
		gThis.m_jWindow.contents().find('.gradient').each(function() {
			$(this).parent().html($(this).next('div').html());
		});
		for (var i in gThis.m_oValues) {
			for (var j in gThis.m_oValues[i]) {
				if (j == 'background-gradient') {
					gThis.m_jWindow.contents().find(i).each(function() {
						$(this).append().gradient({
						from: gThis.m_oValues[i][j].substr(1),
						to: gThis.m_oValues[i]['background-color'].substr(1),
						direction: 'horizontal'
					})});
				}
				else {
					gThis.m_jWindow.contents().find(i).css(j, gThis.m_oValues[i][j]);
				}
			}
		}
	};
	
	gThis.Focus = function() { return false; };
	
}, oDefaults);