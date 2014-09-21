/*
* FONT STYLE
*/

var oDefaults = {
		sName: '',
		sLabel: '',
		oClasses: {
			sFieldClass: 'field-font',
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
			sColourPreviewClass: 'colour-preview',
			sFontPreviewClass: 'font-preview'
		},
		oImages: {
			sBold: 'images/icons/font-style-bold.png',
			sUnderline: 'images/icons/font-style-underline.png',
			sItalic: 'images/icons/font-style-italic.png',
			sUppercase: 'images/icons/font-style-uppercase.png',
			sAddRepetition: 'images/icons/buttons/add.png',
			sRemoveRepetition: 'images/icons/buttons/delete.png'
		},
		sFieldType: 'text',
		sDefault: '',
		aoRules: [],
		sComment: '',
		sSelector: ''
};

var GFormFontStyle = GCore.ExtendClass(GFormTextField, function() {
		
		var gThis = this;
		
		gThis.m_jFieldFontFamily;
		gThis.m_jFieldFontStyleBold;
		gThis.m_jFieldFontStyleUnderline;	
		gThis.m_jFieldFontStyleItalic;
		gThis.m_jFieldFontStyleUppercase;
		gThis.m_jFieldFontColour;
		gThis.m_jFieldFontSize;
		
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
			if ((gThis.m_oOptions.sSelector != undefined) && (gThis.m_oOptions.sSelector.length)) {
				gThis.m_jNode.append('<input type="hidden" name="' + gThis.GetName() + '[selector]" value="' + gThis.m_oOptions.sSelector + '"/>');
			}
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
			gThis.m_jFieldFontFamily.val(mValue.family).triggerHandler('change');
			gThis.m_jFieldFontStyleBold.val(mValue.bold);
			gThis.m_jFieldFontStyleUnderline.val(mValue.underline);	
			gThis.m_jFieldFontStyleItalic.val(mValue.italic);
			gThis.m_jFieldFontStyleUppercase.val(mValue.uppercase);
			gThis.m_jFieldFontColour.val(mValue.colour);
			gThis.m_jFieldFontSize.val(mValue.size).triggerHandler('change');
			gThis.UpdatePreview();
		};

		gThis.UpdatePreview = function(){
			
			var bold;
			var underline;
			var italic;
			var uppercase;
			var colour;
			var bDarkBg;
			
			if(gThis.m_jFieldFontColour.val().substr(0, 11) == 'transparent'){
				var r = '00';
				var g = '00';
				var b = '00';
			}else{
				var r = gThis.m_jFieldFontColour.val().substr(0, 2);
				var g = gThis.m_jFieldFontColour.val().substr(2, 2);
				var b = gThis.m_jFieldFontColour.val().substr(4, 2);
				eval('bDarkBg = (0x' + (r ? r : '00') + ' + 0x' + (g ? g : '00') + ' + 0x' + (b ? b : '00') + ') / 3 > 127;');
			}
			
			gThis.m_jColourPreviewNode.css({
				'background-color': "#" + gThis.m_jFieldFontColour.val()
			});

			if(gThis.m_jFieldFontStyleBold.val()==1){
				gThis.m_jImgFontStyleBold.css({'background-color':'#efefef'});
				bold = 'bold';
			}
			else{
				gThis.m_jImgFontStyleBold.css({'background-color':'#ffffff'});
				bold = 'normal';
			}
			
			if(gThis.m_jFieldFontStyleUnderline.val()==1){
				gThis.m_jImgFontStyleUnderline.css({'background-color':'#efefef'});
				underline = 'underline';
			}else{
				gThis.m_jImgFontStyleUnderline.css({'background-color':'#ffffff'});
				underline = 'none';
			}
			
			if(gThis.m_jFieldFontStyleItalic.val()==1){
				italic = 'italic';
				gThis.m_jImgFontStyleItalic.css({'background-color':'#efefef'});
			}else{
				gThis.m_jImgFontStyleItalic.css({'background-color':'#ffffff'});
				italic = 'normal';
			}
			
			if(gThis.m_jFieldFontStyleUppercase.val()==1){
				uppercase = 'uppercase';
				gThis.m_jImgFontStyleUppercase.css({'background-color':'#efefef'});
			}else{
				gThis.m_jImgFontStyleUppercase.css({'background-color':'#ffffff'});
				uppercase = 'none';
			}
			
			gThis.m_jFontPreviewNode.css({
				'font-weight': bold,
				'text-decoration': underline,
				'font-style': italic,
				'font-family': gThis.m_jFieldFontFamily.val(),
				'font-size': gThis.m_jFieldFontSize.val()+"px",
				'color': "#"+gThis.m_jFieldFontColour.val(),
				'text-transform': uppercase,
				'background-color': bDarkBg ? '#000000' : '#ffffff'
			});
				
		};
		
		gThis._AddField = function(sId) {
			
			
			var jFontStyleNode = $('<span class="' + gThis._GetClass('FieldSpan') + ' style"/>');
			var jFontFamilyNode = $('<span class="' + gThis._GetClass('FieldSpan') + ' family"/>');
			var jFontSizeNode = $('<span class="' + gThis._GetClass('FieldSpan') + ' size"/>');
			var jFontPreviewNode = $('<span class="' + gThis._GetClass('FontPreview') + '"/>');
			var jFontColourNode = $('<span class="' + gThis._GetClass('FieldSpan') + ' colour"/>');
			var jColourPreviewNode = $('<span class="' + gThis._GetClass('ColourPreview') + '"/>');
			
			var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
			
			var opt = {'cursor':'pointer'};
			
			var jImgFontStyleBold = $('<img src="'+gThis._GetImage('Bold')+'" />').css(opt);
			var jFieldFontStyleBold = $('<input type="hidden" name="' + gThis.GetName() + '[bold]" value="0"/>');
			
			var jImgFontStyleUnderline = $('<img src="'+gThis._GetImage('Underline')+'" />').css(opt);
			var jFieldFontStyleUnderline = $('<input type="hidden" name="' + gThis.GetName() + '[underline]" value="0"/>');
			
			var jImgFontStyleItalic = $('<img src="'+gThis._GetImage('Italic')+'" />').css(opt);
			var jFieldFontStyleItalic = $('<input type="hidden" name="' + gThis.GetName() + '[italic]" value="0"/>');
			
			var jImgFontStyleUppercase = $('<img src="'+gThis._GetImage('Uppercase')+'" />').css(opt);
			var jFieldFontStyleUppercase = $('<input type="hidden" name="' + gThis.GetName() + '[uppercase]" value="0"/>');

			var jFieldFontFamily = $('<select name="' + gThis.GetName() + '[family]" />');
			for (var i = 0; i < gThis.m_oOptions.aoTypes.length; i++) {
					var oType = gThis.m_oOptions.aoTypes[i];
					jFieldFontFamily.append('<option value="' + oType.sValue + '">' + oType.sLabel + '</option>');
			}
			
			var jFieldFontSize = $('<select name="' + gThis.GetName() + '[size]" />');
			for (var i = 5; i < 25; i++) {
					var oType = gThis.m_oOptions.aoTypes[i];
					jFieldFontSize.append('<option value="' + i + '">' + i + ' px</option>');
			}
			var jFieldFontColour = $('<input type="text" name="' + gThis.GetName() + '[colour]" />');
			
			jFontPreviewNode.html('Lorem ipsum');
			
			jFontStyleNode.append(jImgFontStyleBold).append(jImgFontStyleUnderline).append(jImgFontStyleItalic).append(jImgFontStyleUppercase);
			jFontStyleNode.append(jFieldFontStyleBold).append(jFieldFontStyleUnderline).append(jFieldFontStyleItalic).append(jFieldFontStyleUppercase);
			
			jFontFamilyNode.append(jFieldFontFamily);
			jFontSizeNode.append(jFieldFontSize);
			jFontColourNode.append(jFieldFontColour);
			
			jRepetitionNode.append($('<span class="' + gThis._GetClass('ColourPreview') + '-container"/>').append(jColourPreviewNode)).append(jFontFamilyNode).append(jFontColourNode).append(jFontStyleNode).append(jFontSizeNode).append(jFontPreviewNode);
			gThis.m_jField = jRepetitionNode.find('input,select');
		
			gThis.m_jRepetitionNode = jRepetitionNode;
			gThis.m_jFontFamilyNode = jFontFamilyNode;
			gThis.m_jFontSizeNode = jFontSizeNode;
			gThis.m_jFieldFontFamily = jFieldFontFamily;
			gThis.m_jFieldFontSize = jFieldFontSize;
			gThis.m_jImgFontStyleBold = jImgFontStyleBold;
			gThis.m_jImgFontStyleUnderline = jImgFontStyleUnderline;
			gThis.m_jImgFontStyleItalic = jImgFontStyleItalic;
			gThis.m_jImgFontStyleUppercase = jImgFontStyleUppercase;
			gThis.m_jFieldFontStyleBold = jFieldFontStyleBold;
			gThis.m_jFieldFontStyleUnderline = jFieldFontStyleUnderline;
			gThis.m_jFieldFontStyleItalic = jFieldFontStyleItalic;
			gThis.m_jFieldFontStyleUppercase = jFieldFontStyleUppercase;
			gThis.m_jFontPreviewNode = jFontPreviewNode;
			gThis.m_jFontColourNode = jFontColourNode;
			gThis.m_jFieldFontColour = jFieldFontColour;
			gThis.m_jColourPreviewNode = jColourPreviewNode;
			
			return jRepetitionNode;
		};
		
		gThis.OnShow = function() {
				gThis.m_bShown = true;
		};
		
		gThis._InitializeEvents = function() {
			gThis.m_jField.bind('change keyup',function(){
				gThis.UpdatePreview();
			});
			
			gThis.m_jImgFontStyleBold.click(function(){
				if(gThis.m_jFieldFontStyleBold.val()==1){
					gThis.m_jImgFontStyleBold.css({'background-color':'#ffffff'});
					gThis.m_jFieldFontStyleBold.val(0).triggerHandler('change');	
				}
				else{
					gThis.m_jImgFontStyleBold.css({'background-color':'#efefef'});
					gThis.m_jFieldFontStyleBold.val(1).triggerHandler('change');	
				}
				gThis.UpdatePreview();
			});
			
			gThis.m_jImgFontStyleUnderline.click(function(){
				if(gThis.m_jFieldFontStyleUnderline.val()==1){
					gThis.m_jImgFontStyleUnderline.css({'background-color':'#ffffff'});
					gThis.m_jFieldFontStyleUnderline.val(0).triggerHandler('change');	
				}
				else{
					gThis.m_jImgFontStyleUnderline.css({'background-color':'#efefef'});
					gThis.m_jFieldFontStyleUnderline.val(1).triggerHandler('change');	
				}
				gThis.UpdatePreview();
			});
			
			gThis.m_jImgFontStyleItalic.click(function(){
				if(gThis.m_jFieldFontStyleItalic.val()==1){
					gThis.m_jImgFontStyleItalic.css({'background-color':'#ffffff'});
					gThis.m_jFieldFontStyleItalic.val(0).triggerHandler('change');	
				}
				else{
					gThis.m_jImgFontStyleItalic.css({'background-color':'#efefef'});
					gThis.m_jFieldFontStyleItalic.val(1).triggerHandler('change');	
				}
				gThis.UpdatePreview();
			});
			
			gThis.m_jImgFontStyleUppercase.click(function(){
				if(gThis.m_jFieldFontStyleUppercase.val()==1){
					gThis.m_jImgFontStyleUppercase.css({'background-color':'#ffffff'});
					gThis.m_jFieldFontStyleUppercase.val(0).triggerHandler('change');	
				}
				else{
					gThis.m_jImgFontStyleUppercase.css({'background-color':'#efefef'});
					gThis.m_jFieldFontStyleUppercase.val(1).triggerHandler('change');	
				}
				gThis.UpdatePreview();
			});
						
			gThis.m_jFieldFontFamily.GSelect().focus(GEventHandler(function(eEvent) {
				$(this).closest('.field').addClass('focus');
			})).blur(GEventHandler(function(eEvent) {
				$(this).closest('.field').removeClass('focus');
			}));
			
			gThis.m_jFieldFontSize.GSelect().focus(GEventHandler(function(eEvent) {
				$(this).closest('.field').addClass('focus');
			})).blur(GEventHandler(function(eEvent) {
				$(this).closest('.field').removeClass('focus');
			}));
			
			gThis.m_jFieldFontColour.ColorPicker({
				color: '#' + gThis.m_jFieldFontColour.val(),
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				},
				onShow: function(colpkr) {
					$(colpkr).fadeIn(250);
					gThis.m_jFieldFontColour.closest('.field').addClass('focus');
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(250);
					gThis.m_jFieldFontColour.triggerHandler('change');
					gThis.m_jFieldFontColour.closest('.field').removeClass('focus');
					return false;
				},
				onChange: function(hsb, hex, rgb) {
					gThis.UpdatePreview();
					gThis.m_jFieldFontColour.val(hex);
				}
			}).change(GEventHandler(function(eEvent) {
				gThis.UpdatePreview();
			}));
			
			gThis.UpdatePreview();
		};

		
		gThis.Reset = function() {
			gThis.m_jField.eq(0).val(gThis.m_oOptions.sDefault).change();
		};
		
}, oDefaults);