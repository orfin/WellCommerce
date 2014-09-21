/*
* ATTRIBUTE EDITOR
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

var GFormAttributeEditor = GCore.ExtendClass(GFormField, function() {
	
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
		oAttribute = $.extend(GCore.Duplicate({
			name: '',
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
		oValue = $.extend(GCore.Duplicate({
			id: 'new-' + oAttribute.iNewValueIndex++,
			name: ''
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
		/*var jEdit = $('<a rel="edit" href="#"/>').append('<img src="' + gThis._GetImage('Edit') + '" alt="' + GForm.Language.attribute_editor_edit_attribute_values + '" title="' + GForm.Language.attribute_editor_edit_attribute_values + '"/>');
		jEdit.click(GEventHandler(function(eEvent) {
			gThis.EditAttribute(oAttribute.id);
			return false;
		}));*/
		var jRename = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('Rename') + '" alt="' + GForm.Language.attribute_editor_rename_value + '" title="' + GForm.Language.attribute_editor_rename_value + '"/>');
		jRename.click(GEventHandler(function(eEvent) {
			eEvent.stopImmediatePropagation();
			GPrompt(GForm.Language.attribute_editor_rename_value_provide_new_name, function(sName) {
				GCore.StartWaiting();
				gThis.m_oOptions.fRenameValue({
					id: oValue.id,
					name: sName
				}, GCallback(function(eEvent) {
					GCore.StopWaiting();
					GAlert.DestroyThis.apply(eEvent.dMessage);
					if (eEvent.status) {
						gThis._RenameValue(oValue.id, sAttribute, sName);
					}
					else {
						GError(GForm.Language.attribute_editor_rename_value_error, GForm.Language.attribute_editor_rename_value_error_description);
					}
				}, {
					dMessage: this
				}));
			}, {
				sDefault: oValue.name
			});
			return false;
		}));
		var jDelete = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('DeleteFromBase') + '" alt="' + GForm.Language.attribute_editor_remove_value + '" title="' + GForm.Language.attribute_editor_remove_value + '"/>');
		jDelete.click(GEventHandler(function(eEvent) {
			gThis.RemoveValue(gThis.m_sActiveAttribute, oValue.id);
			return false;
		}));
		jValue.append('<span class="' + gThis._GetClass('Name') + '">' + oValue.name + '</span>').append(jDelete).append(jRename);
		return jValue;
	};
	
	gThis._RenameAttribute = function(sId, sName) {
		gThis.m_oAttributes[sId].name = sName;
		gThis.Update();
	};
	
	gThis._RenameValue = function(sId, sAttribute, sName) {
		for (var i in gThis.m_oAttributes[sAttribute].values) {
			if (gThis.m_oAttributes[sAttribute].values[i].id == sId) {
				gThis.m_oAttributes[sAttribute].values[i].name = sName;
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
		//var jEdit = $('<a rel="edit" href="#"/>').append('<img src="' + gThis._GetImage('Edit') + '" alt="' + GForm.Language.attribute_editor_edit_attribute_values + '" title="' + GForm.Language.attribute_editor_edit_attribute_values + '"/>');
		jAttribute.click(GEventHandler(function(eEvent) {
			gThis.EditAttribute(oAttribute.id);
			return false;
		}));
		var jRename = $('<a rel="delete" href="#"/>').append('<img src="' + gThis._GetImage('Rename') + '" alt="' + GForm.Language.attribute_editor_rename_attribute + '" title="' + GForm.Language.attribute_editor_rename_attribute + '"/>');
		jRename.click(GEventHandler(function(eEvent) {
			eEvent.stopImmediatePropagation();
			GPrompt(GForm.Language.attribute_editor_rename_attribute_provide_new_name, function(sName) {
				GCore.StartWaiting();
				gThis.m_oOptions.fRenameAttribute({
					id: oAttribute.id,
					name: sName
				}, GCallback(function(eEvent) {
					GCore.StopWaiting();
					GAlert.DestroyThis.apply(eEvent.dMessage);
					if (eEvent.status) {
						gThis._RenameAttribute(oAttribute.id, sName);
					}
					else {
						GError(GForm.Language.attribute_editor_rename_attribute_error, GForm.Language.attribute_editor_rename_attribute_error_description);
					}
				}, {
					dMessage: this
				}));
			}, {
				sDefault: oAttribute.name
			});
			return false;
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
		jAttribute.append('<span class="' + gThis._GetClass('Name') + '">' + oAttribute.name + '</span>').append(jDelete).append(jDeleteFromBase).append(jRename);//.append(jEdit);
		return jAttribute;
	};
	
	gThis.EditAttribute = function(sAttribute) {
		if (gThis.m_oAttributes[sAttribute] == undefined) {
			return false;
		}
		gThis.m_sActiveAttribute = sAttribute;
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
		var jSelect = $('<select/>');
		jSelect.append('<option value="">' + GForm.Language.attribute_editor_choose_attribute + '</option>');
		for (var i in gThis.m_oAttributes) {
			var oAttribute = gThis.m_oAttributes[i];
			if ($.inArray(oAttribute.id, gThis.m_aSelectedAttributes) != -1) {
				continue;
			}
			jSelect.append('<option value="' + oAttribute.id + '">' + oAttribute.name + '</option>');
		}
		var jAdd = $('<a rel="add" href="#"/>').append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.attribute_editor_add_attribute + '" title="' + GForm.Language.attribute_editor_add_attribute + '"/>');
		jAdd.click(GEventHandler(function(eEvent) {
			gThis._OnAttributeAdd($(this).closest('li').find('select'));
			return false;
		}));
		jAttribute.append($('<div class="field-select"/>').append($('<span class="field"/>').append(jSelect)).append(jAdd));
		return jAttribute;
	};
	
	gThis._WriteValues = function() {
		gThis.m_jValues.empty();
		if (gThis.m_oAttributes[gThis.m_sActiveAttribute] == undefined) {
			gThis.m_jValues.parent().find('h3').text(GForm.Language.attribute_editor_values);
			return;
		}
		gThis.m_jValues.parent().find('h3').text(GForm.Language.attribute_editor_values + ': ' + gThis.m_oAttributes[gThis.m_sActiveAttribute].name);
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
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][name]" value="' + (oAttribute.name).replace('"',"''") + '"/>');
			for (var j in oAttribute.values) {
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][values][' + j + '][id]" value="' + oAttribute.values[j].id + '"/>');
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[editor][' + i + '][values][' + j + '][name]" value="' + (oAttribute.values[j].name).replace('"',"''") + '"/>');
			}
		}
	};
	
	gThis._InitializeEditorEvents = function() {
		gThis.m_jAttributes.find('select').GComboBox();
		gThis.m_jAttributes.find('select').bind('GChange', GEventHandler(function(eEvent) {
			if (gThis._OnAttributeAdd($(this))) {
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
		gThis._AddValue(gThis.m_sActiveAttribute, {
			name: jInput.val()
		});
		gThis.Update();
		return true;
	};
	
	gThis._OnAttributeAdd = function(jSelect) {
		if (jSelect.val() == '') {
			return false;
		}
		if (jSelect.val() == '_new_') {
			gThis._AddAttribute({
				name: jSelect.find('option:selected').text()
			}, true);
		}
		else {
			gThis._AddAttribute({
				id: jSelect.val(),
				name: jSelect.find('option:selected').text()
			});
		}
		gThis.Update();
		return true;
	};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jField = $('<div/>');
		gThis.m_jNode.append(gThis.m_jField);
		gThis.m_jAttributes = $('<ul/>');
		gThis.m_jValues = $('<ul/>');
		gThis.m_jNode.append($('<div class="' + gThis._GetClass('Attributes') + '"/>').append('<h3>' + GForm.Language.attribute_editor_attributes + '</h3>').append(gThis.m_jAttributes));
		gThis.m_jNode.append($('<div class="' + gThis._GetClass('Values') + '"/>').append('<h3>' + GForm.Language.attribute_editor_values + '</h3>').append(gThis.m_jValues));
		gThis.Update();
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