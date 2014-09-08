/*
* TECHNICAL ATTRIBUTE EDITOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	fDeleteAttribute: GCore.NULL,
	oClasses: {
		sFieldClass: 'field-attribute-editor',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sActiveClass: 'active',
		sButtonClass: 'button',
		sAttributesClass: 'attributes-list',
		sValuesClass: 'values-list',
		sAttributeRepetitionClass: 'attribute-repetition',
		sValueRepetitionClass: 'value-repetition',
		sNameClass: 'name'
	},
	oImages: {
		sAdd: 'images/icons/buttons/add.png',
		sEdit: 'images/icons/buttons/edit.png',
		sRename: 'images/icons/buttons/edit.png',
		sDeleteFromBase: 'images/icons/buttons/delete.png',
		sDelete: 'images/icons/buttons/delete-2.png'
	}
};

var GFormTechnicalAttributeEditor = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_oAttributes = {};
	gThis.m_iNewAttributeIndex = 0;
	
	gThis.m_jAttributes;
	gThis.m_jValues;
	gThis.m_aSelectedAttributes = [];
	gThis.m_sActiveAttribute = 0;
	
	gThis._Constructor = function() {
		for (var i in gThis.m_oOptions.aoAttributes) {
			gThis._AddAttribute(GCore.Duplicate(gThis.m_oOptions.aoAttributes[i], true));
		}
		gThis.m_sActiveAttribute = 0;
	};
	
	gThis._AddAttribute = function(oAttribute) {
		
		if (oAttribute instanceof String) {
			oAttribute = {
				name: oAttribute
			};
		}
		var sName = [];
		sName[GCore.iActiveLanguage] = '';
		oAttribute = $.extend(GCore.Duplicate({
			name: sName,
			id: 'new-' + gThis.m_iNewAttributeIndex++,
			values: []
		}, true), oAttribute);
		if (gThis.m_oAttributes[oAttribute.id] == undefined) {
			gThis.m_oAttributes[oAttribute.id] = $.extend(oAttribute, {
				iNewValueIndex: 0
			});
		}
		gThis.m_aSelectedAttributes.push(oAttribute.id);
		gThis.m_sActiveAttribute = oAttribute.id;
		return oAttribute.id;
	};
	
	gThis._AddValue = function(sAttribute, oValue) {
		if ((sAttribute == undefined) || (gThis.m_oAttributes[sAttribute] == undefined)) {
			return null;
		}
		var oAttribute = gThis.m_oAttributes[sAttribute];
		if (oValue instanceof String) {
			oValue = {
				name: oValue
			};
		}
		var sName = [];
		sName[GCore.iActiveLanguage] = '';
		oValue = $.extend(GCore.Duplicate({
			id: 'new-' + oAttribute.iNewValueIndex++,
			name: sName,
			type: GFormTechnicalDataEditor.FIELD_STRING,
		}, true), oValue);
		gThis.m_oAttributes[sAttribute].values.push(oValue);
		return oValue.id;
	};
	
	gThis._WriteValue = function(sAttribute, sValue) {
		if ((sAttribute == undefined) || (gThis.m_oAttributes[sAttribute] == undefined)) {
			return null;
		}
		var oValue = gThis.m_oAttributes[sAttribute].values[sValue];
		var jValue = $('<li class="' + gThis._GetClass('ValueRepetition') + '"/>');
		var jRename = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('Rename') + '" alt="' + GForm.Language.attribute_editor_rename_value + '" title="' + GForm.Language.attribute_editor_rename_value + '"/>');
		jRename.click(GEventHandler(function(eEvent) {
			eEvent.stopImmediatePropagation();
			var jOverlay = $('<div class="technical-data-detail-editor"/>');
			$('body').append(jOverlay);
			jOverlay.GShadow();
			jOverlay.GOverlay({
				fClick: GEventHandler(function(eEvent) {
					jOverlay.remove();
				})
			});
			jOverlay.css({
				left: $(this).offset().left - 161,
				top: $(this).offset().top + 21
			});
			for (var l in GCore.aoLanguages) {
				var jLanguage = $('<div class="field-text"><span class="prefix"><img style="margin-top: 4px;margin-left: 4px;" src="' + GCore.DESIGN_PATH + 'images/languages/' + GCore.aoLanguages[l].flag + '" alt="' + GCore.aoLanguages[l].name + '"/></span><span class="field"><input class="language-' + l + '" type="text" value="' + oValue.name[l] + '"/></span></div>');
				jOverlay.append(jLanguage);
			}
			var jSaveButton = $('<a class="button" href="#"><span>' + GForm.Language.technical_data_save_group + '</span></a>');
			jSaveButton.click(GEventHandler(function(eEvent) {
				for (var l in GCore.aoLanguages) {
					var sName = $('.technical-data-detail-editor').find('.language-' + l).val();
					gThis.m_oOptions.fRenameValue({
						id: oValue.id, 
						name: sName,
						languageid: l
					}, GCallback(function(eEvent) {
						gThis._RenameValue(eEvent.id, sAttribute, eEvent.name, eEvent.languageid);
					}));
				}
				GOverlay.RemoveAll();
				return false;
			}));
			var jCancelButton = $('<a class="button" href="#"><span>' + GForm.Language.tree_cancel + '</span></a>');
			jCancelButton.click(GEventHandler(function(eEvent) {
				GOverlay.RemoveAll();
				return false;
			}));
			jOverlay.append(jSaveButton).append(jCancelButton);
			return false;
		}));
		var jDelete = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('DeleteFromBase') + '" alt="' + GForm.Language.attribute_editor_remove_value + '" title="' + GForm.Language.attribute_editor_remove_value + '"/>');
		jDelete.click(GEventHandler(function(eEvent) {
			gThis.RemoveValue(gThis.m_sActiveAttribute, oValue.id);
			return false;
		}));
		
		var jTypeSelect = $('<select name="" class="type"/>');
		var aoTypes = [
			{id: GFormTechnicalDataEditor.FIELD_STRING, caption: GForm.Language.technical_data_value_type_string},
			{id: GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING, caption: GForm.Language.technical_data_value_type_multilingual_string},
			{id: GFormTechnicalDataEditor.FIELD_TEXT, caption: GForm.Language.technical_data_value_type_text},
			{id: GFormTechnicalDataEditor.FIELD_BOOLEAN, caption: GForm.Language.technical_data_value_type_boolean},
		];
		for (var i = 0; i < aoTypes.length; i++) {
			jTypeSelect.append('<option' + ((aoTypes[i].id == oValue.type) ? ' selected="selected"' : '') + ' value="' + aoTypes[i].id + '">' + aoTypes[i].caption + '</option>');
		}
		
		jTypeSelect.change(function(){
			oValue.type = $(this).val();
			gThis.Update();
		});
		
		if ((oValue.id).substr(0, 4) == 'new-') {
			jValue.append('<span class="' + gThis._GetClass('Name') + '">' + oValue.name[GCore.iActiveLanguage] + '</span>').append(jDelete).append($('<div class="field-select"/>').append($('<span class="field"/>').append(jTypeSelect)));	
		}else{
			jValue.append('<span class="' + gThis._GetClass('Name') + '">' + oValue.name[GCore.iActiveLanguage] + '</span>').append(jDelete).append(jRename).append($('<div class="field-select"/>').append($('<span class="field"/>').append(jTypeSelect)));
		}
		jTypeSelect.GSelect();
		return jValue;
	};
	
	gThis._RenameAttribute = function(sId, sName, sLanguageId) {
		gThis.m_oAttributes[sId].name[sLanguageId] = sName;
		gThis.Update();
	};
	
	gThis._RenameValue = function(sId, sAttribute, sName, sLanguageId) {
		for (var i in gThis.m_oAttributes[sAttribute].values) {
			if (gThis.m_oAttributes[sAttribute].values[i].id == sId) {
				gThis.m_oAttributes[sAttribute].values[i].name[sLanguageId] = sName;
			}
		}
		gThis.Update();
	};
	
	gThis._WriteAttribute = function(sAttribute) {
		if ((sAttribute == undefined) || (gThis.m_oAttributes[sAttribute] == undefined)) {
			return null;
		}
		var oAttribute = gThis.m_oAttributes[sAttribute];
		var jAttribute = $('<li class="' + gThis._GetClass('AttributeRepetition') + ((gThis.m_sActiveAttribute == oAttribute.id) ? ' ' + gThis._GetClass('Active') : '') + '"/>');
		jAttribute.click(GEventHandler(function(eEvent) {
			gThis.EditAttribute(oAttribute.id);
			return false;
		}));
		var jRename = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('Rename') + '" alt="' + GForm.Language.attribute_editor_rename_attribute + '" title="' + GForm.Language.attribute_editor_rename_attribute + '"/>');
		jRename.click(GEventHandler(function(eEvent) {
			var jOverlay = $('<div class="technical-data-detail-editor"/>');
			$('body').append(jOverlay);
			jOverlay.GShadow();
			jOverlay.GOverlay({
				fClick: GEventHandler(function(eEvent) {
					jOverlay.remove();
				})
			});
			jOverlay.css({
				left: $(this).offset().left - 161,
				top: $(this).offset().top + 21
			});
			for (var l in GCore.aoLanguages) {
				var jLanguage = $('<div class="field-text"><span class="prefix"><img style="margin-top: 4px;margin-left: 4px;" src="' + GCore.DESIGN_PATH + 'images/languages/' + GCore.aoLanguages[l].flag + '" alt="' + GCore.aoLanguages[l].name + '"/></span><span class="field"><input class="language-' + l + '" type="text" value="' + oAttribute.name[l] + '"/></span></div>');
				jOverlay.append(jLanguage);
			}
			var jSaveButton = $('<a class="button" href="#"><span>' + GForm.Language.technical_data_save_group + '</span></a>');
			jSaveButton.click(GEventHandler(function(eEvent) {
				for (var l in GCore.aoLanguages) {
					var sName = $('.technical-data-detail-editor').find('.language-' + l).val();
					gThis.m_oOptions.fRenameAttribute({
						id: oAttribute.id, 
						name: sName,
						languageid: l
					}, GCallback(function(eEvent) {
						gThis._RenameAttribute(eEvent.id, eEvent.name, eEvent.languageid);
					}));
				}
				GOverlay.RemoveAll();
				return false;
			}));
			var jCancelButton = $('<a class="button" href="#"><span>' + GForm.Language.tree_cancel + '</span></a>');
			jCancelButton.click(GEventHandler(function(eEvent) {
				GOverlay.RemoveAll();
				return false;
			}));
			jOverlay.append(jSaveButton).append(jCancelButton);
		}));
		
		var jDelete = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('Delete') + '" alt="' + GForm.Language.attribute_editor_remove_attribute + '" title="' + GForm.Language.attribute_editor_remove_attribute + '"/>');
		jDelete.click(GEventHandler(function(eEvent) {
			eEvent.stopImmediatePropagation();
			gThis.RemoveAttribute(oAttribute.id);
			return false;
		}));
		
		var jDeleteFromBase = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('DeleteFromBase') + '" alt="' + GForm.Language.attribute_editor_remove_attribute_from_base + '" title="' + GForm.Language.attribute_editor_remove_attribute_from_base + '"/>');
		jDeleteFromBase.click(GEventHandler(function(eEvent) {
			eEvent.stopImmediatePropagation();
			GWarning(GForm.Language.attribute_editor_remove_attribute_from_base_confirm, GForm.Language.attribute_editor_remove_attribute_from_base_confirm_description, {
				bAutoExpand: true,
				aoPossibilities: [
					{mLink: function() {
						GCore.StartWaiting();
						gThis.m_oOptions.fDeleteAttribute({
							id: oAttribute.id,
							set_id: gThis.m_oOptions.sSetId
						}, GCallback(function(eEvent) {
							GCore.StopWaiting();
							GAlert.DestroyThis.apply(eEvent.dMessage);
							if (eEvent.status) {
								gThis.RemoveAttribute(oAttribute.id);
							}
							else {
								GError(GForm.Language.attribute_editor_remove_attribute_from_base_error, GForm.Language.attribute_editor_remove_attribute_from_base_error_description);
							}
						}, {
							dMessage: this
						}));
					}, sCaption: GForm.Language.attribute_editor_remove_attribute_from_base_ok},
					{mLink: GAlert.DestroyThis, sCaption: GForm.Language.attribute_editor_remove_attribute_from_base_cancel}
				]
			});
			return false;
		}));
		if ((oAttribute.id).substr(0, 4) == 'new-') {
			jAttribute.append('<span class="' + gThis._GetClass('Name') + '">' + oAttribute.name[GCore.iActiveLanguage] + '</span>').append(jDelete);	
		}else{
			jAttribute.append('<span class="' + gThis._GetClass('Name') + '">' + oAttribute.name[GCore.iActiveLanguage] + '</span>').append(jDeleteFromBase).append(jRename);	
		}
		return jAttribute;
	};
	
	gThis.EditAttribute = function(sAttribute) {
		if (gThis.m_oAttributes[sAttribute] == undefined) {
			return false;
		}
		gThis.m_sActiveAttribute = sAttribute;
		GCookie('edited-technical-data-attribute-' + gThis.m_oOptions.sSetId, gThis.m_sActiveAttribute, {
			expires: GCore.p_oParams.iCookieLifetime
		});
		gThis.Update();
	};
	
	gThis.RemoveValue = function(sAttribute, sValue) {
		if (gThis.m_oAttributes[sAttribute] == undefined) {
			return false;
		}
		for (var i in gThis.m_oAttributes[sAttribute].values) {
			if (gThis.m_oAttributes[sAttribute].values[i].id == sValue) {
				gThis.m_oAttributes[sAttribute].values.splice(i, 1);
				break;
			}
		}
		gThis.Update();
	};
	
	gThis.RemoveAttribute = function(sAttribute) {
		if (gThis.m_oAttributes[sAttribute] == undefined) {
			return false;
		}
		for (var i in gThis.m_aSelectedAttributes) {
			if (gThis.m_aSelectedAttributes[i] == sAttribute) {
				gThis.m_aSelectedAttributes.splice(i, 1);
				break;
			}
		}
		if (gThis.m_sActiveAttribute == sAttribute) {
			gThis.m_sActiveAttribute = 0;
		}
		if (sAttribute.substr(0, 4) == 'new-') {
			delete gThis.m_oAttributes[sAttribute];
		}
		gThis.Update();
	};
	
	gThis._WriteValueAdder = function() {
		var jValue = $('<li class="' + gThis._GetClass('ValueRepetition') + '"/>');
		var jInput = $('<input type="text"/>');
		var jAdd = $('<a rel="add" href="#"/>').append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.attribute_editor_add_value + '" title="' + GForm.Language.attribute_editor_add_value + '"/>');
		jAdd.click(GEventHandler(function(eEvent) {
			gThis._OnValueAdd($(this).closest('li').find('input'));
			return false;
		}));
		jValue.append($('<div class="field-text"/>').append($('<span class="field"/>').append(jInput)).append(jAdd));
		return jValue;
	};
	
	gThis._WriteAttributeAdder = function() {
		var jAttribute = $('<li class="' + gThis._GetClass('AttributeRepetition') + '"/>');
		var jInput = $('<input type="text"/>');
		var jAdd = $('<a rel="add" href="#"/>').append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.attribute_editor_add_attribute + '" title="' + GForm.Language.attribute_editor_add_attribute + '"/>');
		jAdd.click(GEventHandler(function(eEvent) {
			gThis._OnAttributeAdd($(this).closest('li').find('input'));
			return false;
		}));
		jAttribute.append($('<div class="field-text"/>').append($('<span class="field"/>').append(jInput)).append(jAdd));
		return jAttribute;
	};
	
	gThis._WriteValues = function() {
		gThis.m_jValues.empty();
		if (gThis.m_oAttributes[gThis.m_sActiveAttribute] == undefined) {
			gThis.m_jValues.parent().find('h3').text(GForm.Language.technical_attribute_editor_values);
			return;
		}
		gThis.m_jValues.parent().find('h3').text(GForm.Language.technical_attribute_editor_values + ': ' + gThis.m_oAttributes[gThis.m_sActiveAttribute].name[GCore.iActiveLanguage]);
		var jValueAdder = gThis._WriteValueAdder();
		for (var i in gThis.m_oAttributes[gThis.m_sActiveAttribute].values) {
			gThis.m_jValues.append(gThis._WriteValue(gThis.m_sActiveAttribute, i));
		}
		gThis.m_jValues.append(jValueAdder);
	};
	
	gThis._WriteAttributes = function() {
		gThis.m_jAttributes.empty();
		var jAttributeAdder = gThis._WriteAttributeAdder();
		for (var i in gThis.m_aSelectedAttributes) {
			gThis.m_jAttributes.append(gThis._WriteAttribute(gThis.m_aSelectedAttributes[i]));
		}
		gThis.m_jAttributes.append(jAttributeAdder);
	};
	
	gThis.Update = function() {
		gThis._WriteAttributes();
		gThis._WriteValues();
		gThis._InitializeEditorEvents();
		gThis.m_jField.empty();
		for (var i in gThis.m_aSelectedAttributes) {
			var oAttribute = gThis.m_oAttributes[gThis.m_aSelectedAttributes[i]];
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + i + ']" value="' + oAttribute.id + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][id]" value="' + oAttribute.id + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][name]" value="' + (oAttribute.name[GCore.iActiveLanguage]).replace('"',"''") + '"/>');
			for (var j in oAttribute.values) {
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][values][' + j + '][id]" value="' + oAttribute.values[j].id + '"/>');
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][values][' + j + '][type]" value="' + oAttribute.values[j].type + '"/>');
				for (var l in GCore.aoLanguages) {
					gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][values][' + j + '][name][' + l + ']" value="' + (oAttribute.values[j].name[l]).replace('"',"''") + '"/>');
				}
			}
		}
	};
	
	gThis._InitializeEditorEvents = function() {
		gThis.m_jAttributes.find('input').keydown(GEventHandler(function(eEvent) {
			if (eEvent.keyCode == 13) {
				eEvent.preventDefault();
				eEvent.stopImmediatePropagation();
				gThis._OnAttributeAdd($(this));
				gThis.m_jAttributes.find('input').focus();
			}
		}));
		
		gThis.m_jValues.find('input').keydown(GEventHandler(function(eEvent) {
			if (eEvent.keyCode == 13) {
				eEvent.preventDefault();
				eEvent.stopImmediatePropagation();
				gThis._OnValueAdd($(this));
				gThis.m_jValues.find('input').focus();
			}
		}));
	};
	
	gThis._OnValueAdd = function(jInput) {
		if (jInput.val() == '') {
			return false;
		}
		var sName = [];
		for (var l in GCore.aoLanguages) {
			if(l == GCore.iActiveLanguage){
				sName[l] = jInput.val();
			}else{
				sName[l] = '';
			}
		}
		gThis._AddValue(gThis.m_sActiveAttribute, {
			name: sName
		});
		gThis.Update();
		return true;
	};
	
	gThis._OnAttributeAdd = function(jInput) {
		if (jInput.val() == '') {
			return false;
		}
		var sName = [];
		for (var l in GCore.aoLanguages) {
			if(l == GCore.iActiveLanguage){
				sName[l] = jInput.val();
			}else{
				sName[l] = 'test';
			}
		}
		gThis._AddAttribute({
			name: sName
		});
		gThis.Update();
		return true;
	};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jField = $('<div/>');
		gThis.m_jNode.append(gThis.m_jField);
		gThis.m_jAttributes = $('<ul/>');
		gThis.m_jValues = $('<ul/>');
		gThis.m_jNode.append($('<div class="' + gThis._GetClass('Attributes') + '"/>').append('<h3>' + GForm.Language.technical_attribute_editor_attributes + '</h3>').append(gThis.m_jAttributes));
		gThis.m_jNode.append($('<div class="' + gThis._GetClass('Values') + '"/>').append('<h3>' + GForm.Language.technical_attribute_editor_values + '</h3>').append(gThis.m_jValues));
		gThis.Update();
		var sLastActive = GCookie('edited-technical-data-attribute-' + gThis.m_oOptions.sSetId);
		if(sLastActive != undefined && sLastActive > 0 && gThis.m_oAttributes[sLastActive] != undefined){
			if(gThis.m_oOptions.asDefaults != undefined && gThis.m_oOptions.asDefaults.length && $.inArray(sLastActive, gThis.m_oOptions.asDefaults) == -1){
				if(gThis.m_oOptions.asDefaults[0] != undefined){
					gThis.m_sActiveAttribute = gThis.m_oOptions.asDefaults[0];
					gThis.EditAttribute(gThis.m_sActiveAttribute);
				}
			}else{
				if(gThis.m_oOptions.asDefaults != undefined && gThis.m_oOptions.asDefaults[0] != undefined){
					gThis.m_sActiveAttribute = sLastActive;
					gThis.EditAttribute(gThis.m_sActiveAttribute);
				}
			}
		}
	};
	
	gThis.Populate = function(mValue) {
		gThis.m_aSelectedAttributes = mValue;
		gThis.Update();
	};
	
	gThis.Reset = function() {
		gThis.m_oAttributes = {};
		for (var i in gThis.m_oOptions.aoAttributes) {
			gThis._AddAttribute(GCore.Duplicate(gThis.m_oOptions.aoAttributes[i], true));
		}
		gThis.m_sActiveAttribute = 0;
		gThis.Update();
	};
	
}, oDefaults);