/*
* TECHNICAL DATA EDITOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-technical-data-editor',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sDisabledClass: 'disabled',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-repetition',
		sRemoveRepetitionClass: 'remove-repetition',
		sGroupClass: 'group',
		sAttributeClass: 'attribute'
	},
	oImages: {
		sDeleteIcon: 'images/icons/datagrid/delete.png',
		sSaveIcon: 'images/icons/datagrid/save.png',
		sAddIcon: 'images/icons/datagrid/add.png',
		sBlankIcon: 'images/icons/buttons/blank.png',
		sEditIcon: 'images/icons/datagrid/edit.png',
		sDelete: 'images/buttons/small-delete.png',
		sAdd: 'images/buttons/small-add.png'
	},
	fGetSets: GCore.NULL,
	fGetTechnicalAttributesForSet: GCore.NULL,
	fSaveSet: GCore.NULL,
	fDeleteSet: GCore.NULL,
	fSaveAttribute: GCore.NULL,
	fDeleteAttribute: GCore.NULL,
	fSaveAttributeGroup: GCore.NULL,
	fDeleteAttributeGroup: GCore.NULL,
	fGetValuesForAttribute: GCore.NULL,
	sFieldType: 'text',
	sDefault: '',
	aoRules: [],
	sComment: '',
	aTechnicalAttributes: [],
	aAttributeGroups: []
};

var GFormTechnicalDataEditor = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_bResized = false;
	
	gThis.m_bSetAltered = false;
	gThis.m_bIgnoreSetChange = false;
	
	gThis.m_aoSets = [];
	gThis.m_aoAttributes = [];
	gThis.m_oValues = {};
	
	gThis.m_sCurrentSet = '';
	
	gThis.m_jSets;
	gThis.m_jAttributes;
	gThis.m_jAdd;
	gThis.m_jFields;
	
	gThis.m_sGroupOptions;
	gThis.m_sAttributeOptions;
	
	gThis.m_iLoads = ((gThis.m_oOptions.sSetId != undefined) && gThis.m_oOptions.sSetId) ? 0 : 1;
	
	gThis._PrepareNode = function() {
		
		gThis.m_sCurrentSet = gThis.m_oOptions.sSetId;
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jSets = $('<div/>');
		gThis.m_jAttributes = $('<fieldset/>');
		
		gThis.m_jFields = $('<div/>');
		
		gThis.m_jNode.append(gThis.m_jSets);
		gThis.m_jNode.append($('<div class="technical-data-info"><div class="groups">Grupa atrybutów</div><div class="attributes">Atrybuty</div><div class="values">Wartości</div></div>'));
		gThis.m_jNode.append(gThis.m_jAttributes);
		gThis.m_jNode.append(gThis.m_jFields);
		
	};
	
	gThis.UpdateFields = function() {
		gThis.m_jFields.empty();
		var sFields = '';
		sFields += ('<input type="hidden" name="' + gThis.GetName() + '[set]" value="' + gThis.m_sCurrentSet + '"/>');
		for (var i = 0; (gThis.m_aoAttributes[i] != undefined); i++) {
			sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][id]" value="' + gThis.m_aoAttributes[i].id + '"/>');
			if (String(gThis.m_aoAttributes[i].id).substr(0, 3) == 'new') {
				for (var l in GCore.aoLanguages) {
					sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][caption][' + l + ']" value="' + ((gThis.m_aoAttributes[i].caption[l] != undefined) ? gThis.m_aoAttributes[i].caption[l] : '') + '"/>');
				}
			}
			for (var j = 0; (gThis.m_aoAttributes[i].children[j] != undefined); j++) {
				sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][id]" value="' + gThis.m_aoAttributes[i].children[j].id + '"/>');
				sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][type]" value="' + gThis.m_aoAttributes[i].children[j].type + '"/>');
				if (String(gThis.m_aoAttributes[i].children[j].id).substr(0, 3) == 'new') {
					for (var l in GCore.aoLanguages) {
						var caption = ((gThis.m_aoAttributes[i].children[j].caption[l] != undefined) ? gThis.m_aoAttributes[i].children[j].caption[l] : '');
						sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][caption][' + l + ']" value="' + caption.replace('"',"''") + '"/>');
					}
				}
				switch (gThis.m_aoAttributes[i].children[j].type) {
					case GFormTechnicalDataEditor.FIELD_STRING:
						sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][value]" value="' + ((gThis.m_aoAttributes[i].children[j].value != undefined) ? gThis.m_aoAttributes[i].children[j].value : '') + '"/>');
						break;
					case GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING:
						for (var l in GCore.aoLanguages) {
							sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][value][' + l + ']" value="' + (((gThis.m_aoAttributes[i].children[j].value != undefined) && (gThis.m_aoAttributes[i].children[j].value[l] != undefined)) ? gThis.m_aoAttributes[i].children[j].value[l] : '') + '"/>');
						}
						break;
					case GFormTechnicalDataEditor.FIELD_TEXT:
						sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][value]" value="' + ((gThis.m_aoAttributes[i].children[j].value != undefined) ? gThis.m_aoAttributes[i].children[j].value : '') + '"/>');
						break;
					case GFormTechnicalDataEditor.FIELD_IMAGE:
						sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][value]" value="' + ((gThis.m_aoAttributes[i].children[j].value != undefined) ? gThis.m_aoAttributes[i].children[j].value : '') + '"/>');
						break;
					case GFormTechnicalDataEditor.FIELD_BOOLEAN:
						sFields += ('<input type="hidden" name="' + gThis.GetName() + '[groups][' + i + '][attributes][' + j + '][value]" value="' + (gThis.m_aoAttributes[i].children[j].value ? '1' : '0') + '"/>');
						break;
				}
			}
		}
		gThis.m_jFields.html(sFields);
	};
	
	gThis.OnShow = function() {
		if (gThis.m_bShown) {
			return;
		}
		gThis.m_bShown = true;
		gThis.LoadSets();
	};
	
	gThis.OnFocus = function(eEvent) {
		gThis._ActivateFocusedTab(eEvent);
	};
	
	gThis.OnBlur = function(eEvent) {
	};
	
	gThis.OnReset = function() {
		gThis.m_sCurrentSet = gThis.m_oOptions.sSetId;
		gThis.m_iLoads = 0;
		gThis.LoadSets();
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (mValue == undefined) {
			return;
		}
		gThis.m_aoAttributes = [];
		for (var i = 0; i < mValue.length; i++) {
			var bFound = false;
			var l;
			for (l in gThis.m_oOptions.aAttributeGroups) {
				if (gThis.m_oOptions.aAttributeGroups[l].id == mValue[i].id) {
					bFound = true;
					break;
				}
			}
			if (!bFound) {
				continue;
			}
			var aoChildren = [];
			if (mValue[i].children != undefined) {
				for (var j = 0; j < mValue[i].children.length; j++) {
					var oAttribute = mValue[i].children[j];
					var bFound = false;
					var k;
					for (k in gThis.m_oOptions.aTechnicalAttributes) {
						if (gThis.m_oOptions.aTechnicalAttributes[k].id == oAttribute.id) {
							bFound = true;
							break;
						}
					}
					if (!bFound) {
						continue;
					}
					aoChildren.push($.extend({}, gThis.m_oOptions.aTechnicalAttributes[k], {
						value: oAttribute.value,
						set_id: oAttribute.set_id
					}));
				}
			}
			gThis.m_aoAttributes.push($.extend({},gThis.m_oOptions.aAttributeGroups[l], {
				children: aoChildren,
				set_id: mValue[i].set_id
			}));
		}
		gThis._WriteTechnicalAttributes();
	};
	
	gThis._InitializeEvents = function(sRepetition) {
	};
	
	gThis.LoadSets = function(fOnSuccess) {
		gThis.m_jSets.html('<div class="field-select"><label>' + GForm.Language.technical_data_choose_set + '</label><span class="repetition"><span class="waiting"></span></span></div>');
		var sProductId = gThis.m_oOptions.sProductId;
		var asCategoryIds = [];
		gThis.m_oOptions.fGetSets({
			productId: sProductId,
			categoryIds: asCategoryIds
		}, GCallback(gThis._OnSetsLoad, {
			fOnSuccess: fOnSuccess
		}));
	};
	
	gThis._OnSetsLoad = GEventHandler(function(eEvent) {
		gThis.m_aoSets = eEvent.aoSets;
		gThis._WriteSets();
		if ((gThis.m_sCurrentSet == undefined) && (gThis.m_aoSets.length > 0)) {
			//gThis.LoadTechnicalAttributesForSet(gThis.m_aoSets[0].id);
		}
		else {
			var bFound = false;
			for (var i in gThis.m_aoSets) {
				if (gThis.m_aoSets[i].id == gThis.m_sCurrentSet) {
					bFound = true;
					break;
				}
			}
			if (bFound) {
				gThis.LoadTechnicalAttributesForSet(gThis.m_sCurrentSet);
			}
			else {
//				gThis.m_bSetAltered = false;
			}
		}
		if (eEvent.fOnSuccess != undefined) {
			eEvent.fOnSuccess(eEvent);
		}
	});
	
	gThis._WriteSets = function() {
		gThis.m_jSets.empty();
		var jSelect = $('<select id="' + gThis.GetName() + '__set"/>');
		jSelect.append('<option value="">---</option>');
		for (var i = 0; i < gThis.m_aoSets.length; i++) {
			var oSet = gThis.m_aoSets[i];
			jSelect.append('<option' + ((oSet.id == gThis.m_sCurrentSet) ? ' selected="selected"' : '') + ' value="' + oSet.id + '"' + (oSet.recommended ? ' class="strong"' : '') + '>' + oSet.caption + '</option>');
		}
		var jField = $('<div class="field-select"><label for="' + gThis.GetName() + '__set">' + GForm.Language.technical_data_choose_set + '</label><span class="repetition"><span class="field"></span></span></div>');
		
		jField.find('.field').append(jSelect).after($('<span class="suffix"></span>'));
		gThis.m_jSets.append(jField);
		jSelect.GSelect();
		jSelect.change(function(eEvent) {
			gThis._OnSetchange(eEvent);
		});
		
	};
	
	gThis._OnSetchange = new GEventHandler(function(eEvent) {
		var sChosenSet = $(eEvent.currentTarget).val();
		if (gThis.m_bIgnoreSetChange) {
			gThis.m_bIgnoreSetChange = false;
			return;
		}
		if (sChosenSet == '') {
			gThis.m_sCurrentSet = '';
			gThis.UpdateFields();
			return;
		}
		if (gThis.m_bSetAltered) {
			GAlert(GForm.Language.technical_data_unsaved_changes, GForm.Language.technical_data_unsaved_changes_description, {
				aoPossibilities: [
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
							gThis.LoadTechnicalAttributesForSet(sChosenSet);
						}),
						sCaption: GForm.Language.technical_data_unsaved_changes_discard
					},
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
							gThis.m_bIgnoreSetChange = true;
							gThis.m_jSets.find('select').val(gThis.m_sCurrentSet).change();
						}),
						sCaption: GForm.Language.technical_data_unsaved_changes_cancel
					}
				]
			});
		}
		else {
			gThis.LoadTechnicalAttributesForSet(sChosenSet);
		}
	});
	
	gThis.LoadTechnicalAttributesForSet = function(sId) {
		gThis.m_sCurrentSet = sId;
		if (gThis.m_iLoads++ < 1) {
			gThis._WriteTechnicalAttributes();
			return;
		}
		gThis.m_oOptions.fGetTechnicalAttributesForSet({
			setId: gThis.m_sCurrentSet
		}, GCallback(gThis._OnTechnicalAttributesLoad));
	};
	
	gThis._OnTechnicalAttributesLoad = GEventHandler(function(eEvent) {
		gThis.m_aoAttributes = eEvent.aoAttributes;
		gThis.m_bSetAltered = false;
		gThis._WriteTechnicalAttributes();
	});
	
	gThis._WriteTechnicalAttributes = function() {
		gThis._UpdateGroupOptions();
		gThis._UpdateAttributeOptions();
		gThis.m_jAttributes.empty();
		gThis.m_jAdd = $('<a href="#" class="add-repetition"/>');
		gThis.m_jAdd.append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.technical_data_add_new_group + '" title="' + GForm.Language.technical_data_add_new_group + '"/>');
		gThis.m_jAttributes.append(gThis.m_jAdd);
		gThis.m_jAdd.click(GEventHandler(function(eEvent) {
			var oGroup = gThis._CreateAttributeGroup();
			gThis.m_aoAttributes.push(oGroup);
			gThis.m_bSetAltered = true;
			gThis._UpdateGroupOptions();
			gThis.AddAttributeGroup(oGroup);
			gThis._UpdateIndices();
			gThis.UpdateFields();
			return false;
		}));
		for (var i = 0; (gThis.m_aoAttributes[i] != undefined); i++) {
			var oGroup = gThis.m_aoAttributes[i];
			gThis.AddAttributeGroup(oGroup);
		}
		gThis._UpdateIndices();
		gThis.UpdateValues();
	};
	
	gThis._CreateAttributeGroup = function() {
		var oGroup = {
			id: 'new-' + GFormTechnicalDataEditor.s_iNewId++,
			caption: {},
			children: []
		};
		for (var l in GCore.aoLanguages) {
			oGroup.caption[l] = '';
		}
		return oGroup;
	};
	
	gThis._CreateAttribute = function() {
		var oAttribute = {
			id: 'new-' + GFormTechnicalDataEditor.s_iNewId++,
			caption: {},
			type: GFormTechnicalDataEditor.FIELD_STRING,
			value: ''
		};
		for (var l in GCore.aoLanguages) {
			oAttribute.caption[l] = '';
		}
		return oAttribute;
	};
	
	gThis.DeleteAttributeGroup = function(iGroup) {
		gThis.m_aoAttributes.splice(iGroup, 1);
		gThis.m_jAttributes.children('.group:eq(' + iGroup + ')').remove();
		gThis._UpdateGroupOptions();
		gThis._UpdateIndices();
		gThis.UpdateFields();
	};
	
	gThis.DeleteAttribute = function(iGroup, iAttribute) {
		gThis.m_aoAttributes[iGroup].children.splice(iAttribute, 1);
		gThis.m_jAttributes.children('.group:eq(' + (iGroup + 1) + ') .attributes .attribute:eq(' + iAttribute + ')').remove();
		gThis._UpdateAttributeOptions();
		gThis._UpdateIndices();
		gThis.UpdateFields();
	};
	
	gThis._UpdateAttributeOptions = function() {
		gThis.m_sAttributeOptions = '';
		for (var j = 0; j < gThis.m_oOptions.aTechnicalAttributes.length; j++) {
			var oTechnicalAttribute = gThis.m_oOptions.aTechnicalAttributes[j];
			gThis.m_sAttributeOptions += '<option value="' + oTechnicalAttribute.id + '">' + oTechnicalAttribute.caption[GCore.iActiveLanguage] + '</option>';
		}
	};
	
	gThis._UpdateGroupOptions = function() {
		gThis.m_sGroupOptions = '';
		
		var aSelectedAttributes = [];
		$.each(gThis.m_aoAttributes, function(a, attribute){
			aSelectedAttributes.push(attribute.id);
		});
		gThis.m_sGroupOptions += '<option value="">---</option>';
		for (var j = 0; j < gThis.m_oOptions.aAttributeGroups.length; j++) {
			var oAttributeGroup = gThis.m_oOptions.aAttributeGroups[j];
			if ($.inArray(oAttributeGroup.id, aSelectedAttributes) != -1) {
				continue;
			}
			if(gThis.m_sCurrentSet > 0){
				if(oAttributeGroup.set_id != undefined && oAttributeGroup.set_id == gThis.m_sCurrentSet){
					gThis.m_sGroupOptions += '<option value="' + oAttributeGroup.id + '">' + oAttributeGroup.caption[GCore.iActiveLanguage] +'</option>';
				}
			}else{
				gThis.m_sGroupOptions += '<option value="' + oAttributeGroup.id + '">' + oAttributeGroup.caption[GCore.iActiveLanguage] +'</option>';
			}
		}
	}; 
	
	gThis.AddAttributeGroup = function(oGroup) {
		if (oGroup == undefined) {
			oGroup = {};
		}
		var jGroup = $('<div class="' + gThis._GetClass('Group') + ' GFormRepetition"/>');
		var jGroupSelect = $('<select/>').addClass('attribute-group');
		jGroupSelect.html(gThis.m_sGroupOptions);
		if(oGroup.set_id > 0){
			jGroup.append($('<div class="field-technical-group"/>').prepend($('<span class="constant" />').html(oGroup.caption[GCore.iActiveLanguage])));
			gThis.m_jAttributes.append(jGroup);
			var jAttributes = $('<div class="attributes"/>');
			jGroup.append(jAttributes);
			var jAddAttribute = $('<a href="#" class="add-attribute"><img src="' + gThis._GetImage('Icon') + '"/></a>');
			jAttributes.append(jAddAttribute);
			jAddAttribute.hide();
			if (oGroup.children != undefined) {
				for (var j = 0; (oGroup.children[j] != undefined); j++) {
					var oAttribute = oGroup.children[j];
					gThis.AddAttribute(jAttributes, oAttribute, oGroup.id);
				}
			}
		}else{
			var jGroupEdit = $('<img class="edit" src="' + gThis._GetImage('EditIcon') + '" alt="' + GForm.Language.technical_data_edit_group + '" title="' + GForm.Language.technical_data_edit_group + '"/>');
			jGroup.append($('<div class="field-select"/>').append($('<span class="suffix"/>').append(jGroupEdit)).prepend($('<span class="field"/>').append(jGroupSelect)));
			jGroupEdit.click(gThis._OnGroupEditClick);
			jGroupSelect.GComboBox();
			jGroupSelect.val(oGroup.id).change();
			jGroupSelect.change(GEventHandler(function(eEvent) {
				$(this).closest('.field-select').find('input:text').change();
			}));
			if (oGroup.caption != undefined) {
				jGroup.find('input:text').val(oGroup.caption[GCore.iActiveLanguage]);
			}
			jGroup.find('input:text').change(gThis._OnGroupChange);
			gThis.m_jAttributes.append(jGroup);
			var jAttributes = $('<div class="attributes"/>');
			jGroup.append(jAttributes);
			var jAddAttribute = $('<a href="#" class="add-attribute"><img src="' + gThis._GetImage('AddIcon') + '" title="' + GForm.Language.technical_data_add_new_attribute + '" alt="' + GForm.Language.technical_data_add_new_attribute + '"/></a>');
			jAttributes.append(jAddAttribute);
			jAddAttribute.click(gThis._OnAttributeAddClick);
			if (oGroup.children != undefined) {
				for (var j = 0; (oGroup.children[j] != undefined); j++) {
					var oAttribute = oGroup.children[j];
					gThis.AddAttribute(jAttributes, oAttribute);
				}
			}
			var jDelete = $('<a href="#" class="delete-repetition"/>');
			jDelete.append('<img src="' + gThis._GetImage('Delete') + '" alt="' + GForm.Language.technical_data_delete_group + '" title="' + GForm.Language.technical_data_delete_group + '"/>');
			jDelete.click(gThis._OnGroupDeleteClick);
			jGroup.append(jDelete);
		}
		
	};
	
	gThis._OnGroupEditClick = GEventHandler(function(eEvent) {
		var iGroupIndex = $(this).closest('.group').data('iGroupIndex');
		var oGroup = gThis.m_aoAttributes[iGroupIndex];
		var jOverlay = $('<div class="technical-data-detail-editor"/>').data('iGroupIndex', iGroupIndex);
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
			var jLanguage = $('<div class="field-text"><span class="prefix"><img src="' + GCore.DESIGN_PATH + '_images_common/icons/images/languages//' + GCore.aoLanguages[l].flag + '" alt="' + GCore.aoLanguages[l].name + '"/></span><span class="field"><input class="language-' + l + '" type="text" value="' + ((oGroup.caption[l] == undefined) ? '' : oGroup.caption[l]) + '"/></span></div>');
			jOverlay.append(jLanguage);
		}
		var jSaveButton = $('<a class="button ok" href="#"><span>' + GForm.Language.technical_data_save_group + '</span></a>');
		jSaveButton.click(GEventHandler(function(eEvent) {
			var iGroupIndex = $(this).closest('.technical-data-detail-editor').data('iGroupIndex');
			for (var l in GCore.aoLanguages) {
				gThis.m_aoAttributes[iGroupIndex].caption[l] = $(this).closest('.technical-data-detail-editor').find('.language-' + l).val();
			}
			GOverlay.RemoveAll();
			gThis.m_oOptions.fSaveAttributeGroup({
				attributeGroupId: oGroup.id,
				attributeGroupName: oGroup.caption
			}, GCallback(gThis._OnAttributeGroupSave, {
				iGroupIndex: iGroupIndex
			}));
			return false;
		}));
		var jDeleteButton = $('<a class="button delete" href="#"><span>' + GForm.Language.technical_data_delete_group_permanently + '</span></a>');
		jDeleteButton.click(GEventHandler(function(eEvent) {
			var iGroupIndex = $(this).closest('.technical-data-detail-editor').data('iGroupIndex');
			var sAttributeGroup = gThis.m_aoAttributes[iGroupIndex].id;
			GOverlay.RemoveAll();
			GAlert(GForm.Language.technical_data_delete_attribute_group, GForm.Language.technical_data_delete_attribute_group_description, {
				aoPossibilities: [
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
							for (var i in gThis.m_oOptions.aAttributeGroups) {
								if (gThis.m_oOptions.aAttributeGroups[i].id == gThis.m_aoAttributes[iGroupIndex].id) {
									gThis.m_oOptions.aAttributeGroups.splice(i, 1);
									break;
								}
							}
							gThis.DeleteAttributeGroup(iGroupIndex);
							gThis.m_oOptions.fDeleteAttributeGroup({
								attributeGroupId: sAttributeGroup
							}, GCallback(gThis._OnAttributeGroupDeleted));
						}),
						sCaption: GMessageBar.Language.ok
					},
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
						}),
						sCaption: GMessageBar.Language.cancel
					}
				]
			});
		}));
		jOverlay.append(jSaveButton).append(jDeleteButton);
	});
	
	gThis._OnGroupDeleteClick = GEventHandler(function(eEvent) {
		gThis.DeleteAttributeGroup($(this).closest('.group').data('iGroupIndex'));
		gThis.m_bSetAltered = true;
		return false;
	});
	
	gThis._OnGroupChange = GEventHandler(function(eEvent) {
		gThis.m_bSetAltered = true;
		var bFound = false;
		for (var k in gThis.m_oOptions.aAttributeGroups) {
			if (gThis.m_oOptions.aAttributeGroups[k].caption[GCore.iActiveLanguage] == $(this).val()) {
				bFound = true;
				break;
			}
		}
		if (bFound) {
			gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].id = gThis.m_oOptions.aAttributeGroups[k].id;					
			for (var l in GCore.aoLanguages) {
				gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].caption[l] = (gThis.m_oOptions.aAttributeGroups[k].caption[l] == undefined) ? '' : gThis.m_oOptions.aAttributeGroups[k].caption[l];
			}
		}
		else {
			gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].id = 'new-' + GFormTechnicalDataEditor.s_iNewId++;
			for (var l in GCore.aoLanguages) {
				if (l == GCore.iActiveLanguage) {
					gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].caption[l] = $(this).val();
					continue;
				}
				gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].caption[l] = '';
			}
		}
		gThis.UpdateFields();
	});
	
	gThis._OnAttributeAddClick = GEventHandler(function(eEvent) {
		var oNewAttribute = gThis._CreateAttribute();
		gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].children.push(oNewAttribute);
		gThis.AddAttribute($(this).closest('.group').children('.attributes:first'), oNewAttribute, gThis.m_aoAttributes[$(this).closest('.group').data('iGroupIndex')].id);
		gThis._UpdateIndices();
		gThis.UpdateFields();
		return false;
	});
	
	gThis.AddAttribute = function(jGroup, oAttribute, iGroupIndex) {
		if (oAttribute == undefined) {
			oAttribute = {};
		}
		var jAttribute = $('<div class="' + gThis._GetClass('Attribute') + '"/>');
		var jAttributeSelect = $('<select/>');
		
		var aoActiveGroupAttributes = [];
		for (var j = 0; j < gThis.m_oOptions.aAttributeGroups.length; j++) {
			var oGroup = gThis.m_oOptions.aAttributeGroups[j];
			if(oGroup.id == iGroupIndex){
				aoActiveGroupAttributes = oGroup.attributes;
			}
		}
		
		var sAttributeOptions = '<option value="">---</option>';
		for (var j = 0; j < gThis.m_oOptions.aTechnicalAttributes.length; j++) {
			var oTechnicalAttribute = gThis.m_oOptions.aTechnicalAttributes[j];
			if ($.inArray(oTechnicalAttribute.id, aoActiveGroupAttributes) != -1) {
				sAttributeOptions += '<option value="' + oTechnicalAttribute.id + '">' + oTechnicalAttribute.caption[GCore.iActiveLanguage] + '</option>';
			}
		}
			
		jAttributeSelect.html(sAttributeOptions);
		if(oAttribute.set_id > 0){
			jAttribute.append($('<div class="field-technical-attribute"/>').prepend($('<span class="constant"/>').html(oAttribute.caption[GCore.iActiveLanguage])));
			jGroup.children('.add-attribute').before(jAttribute);
			var jDelete = $('<img src="' + gThis._GetImage('BlankIcon') + '" />');
			jAttribute.find('.field-select:first').prepend($('<span class="prefix"/>').append(jDelete));
			var jValue = $('<div class="value"/>');
			jAttribute.append(jValue);
		}else{
			var jAttributeEdit = $('<img class="edit" src="' + gThis._GetImage('EditIcon') + '" alt="' + GForm.Language.technical_data_edit_attribute + '" title="' + GForm.Language.technical_data_edit_attribute + '"/>');
			jAttribute.append($('<div class="field-select"/>').append($('<span class="suffix"/>').append(jAttributeEdit)).prepend($('<span class="field"/>').append(jAttributeSelect)));
			jAttributeEdit.click(gThis._OnAttributeEditClick);
			jAttributeSelect.GComboBox();
			jAttributeSelect.val(oAttribute.id).change();
			jAttributeSelect.change(GEventHandler(function(eEvent) {
				$(this).closest('.field-select').find('input:text').change();
			}));
			if (oAttribute.caption != undefined) {
				jAttribute.find('input:text').val(oAttribute.caption[GCore.iActiveLanguage]);
			}
			jAttribute.find('input:text').change(gThis._OnAttributeChange);
			jGroup.children('.add-attribute').before(jAttribute);
			var jDelete = $('<a href="#"/>');
			jDelete.append('<img src="' + gThis._GetImage('DeleteIcon') + '" alt="' + GForm.Language.technical_data_delete_attribute + '" title="' + GForm.Language.technical_data_delete_attribute + '"/>');
			jDelete.click(gThis._OnAttributeDeleteClick);
			jAttribute.find('.field-select:first').prepend($('<span class="prefix"/>').append(jDelete));
			var jValue = $('<div class="value"/>');
			jAttribute.append(jValue);
		}
		
		gThis._UpdateValueField(oAttribute, jAttribute);
	};
	
	gThis._OnAttributeEditClick = GEventHandler(function(eEvent) {
		var iGroupIndex = $(this).closest('.group').data('iGroupIndex');
		var iAttributeIndex = $(this).closest('.attribute').data('iAttributeIndex');
		var oAttribute = gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex];
		var jOverlay = $('<div class="technical-data-detail-editor"/>').data('iGroupIndex', iGroupIndex).data('iAttributeIndex', iAttributeIndex);
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
			var jLanguage = $('<div class="field-text"><span class="prefix"><img src="' + GCore.DESIGN_PATH + 'images/languages/' + GCore.aoLanguages[l].flag + '" alt="' + GCore.aoLanguages[l].name + '"/></span><span class="field"><input class="language-' + l + '" type="text" value="' + ((oAttribute.caption[l] == undefined) ? '' : oAttribute.caption[l]) + '"/></span></div>');
			jOverlay.append(jLanguage);
		}
		var jTypeSelect = $('<select class="type"/>');
		var aoTypes = [
			{id: GFormTechnicalDataEditor.FIELD_STRING, caption: GForm.Language.technical_data_value_type_string},
			{id: GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING, caption: GForm.Language.technical_data_value_type_multilingual_string},
			{id: GFormTechnicalDataEditor.FIELD_TEXT, caption: GForm.Language.technical_data_value_type_text},
			//{id: GFormTechnicalDataEditor.FIELD_IMAGE, caption: GForm.Language.technical_data_value_type_image},
			{id: GFormTechnicalDataEditor.FIELD_BOOLEAN, caption: GForm.Language.technical_data_value_type_boolean}
		];
		for (var i = 0; i < aoTypes.length; i++) {
			jTypeSelect.append('<option' + ((aoTypes[i].id == oAttribute.type) ? ' selected="selected"' : '') + ' value="' + aoTypes[i].id + '">' + aoTypes[i].caption + '</option>');
		}
		jOverlay.append($('<div class="field-select"/>').append($('<span class="field"/>').append(jTypeSelect)));
		jTypeSelect.GSelect();
		var jSaveButton = $('<a class="button ok" href="#"><span>' + GForm.Language.technical_data_save_attribute + '</span></a>');
		jSaveButton.click(GEventHandler(function(eEvent) {
			var iAttributeIndex = $(this).closest('.technical-data-detail-editor').data('iAttributeIndex');
			var iGroupIndex = $(this).closest('.technical-data-detail-editor').data('iGroupIndex');
			for (var i in gThis.m_aoAttributes) {
				for (var j in gThis.m_aoAttributes[i].children) {
					if (gThis.m_aoAttributes[i].children[j].id != gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].id) {
						continue;
					}
					gThis.m_aoAttributes[i].children[j].type = parseInt($(this).closest('.technical-data-detail-editor').find('.type').val());
					for (var l in GCore.aoLanguages) {
						gThis.m_aoAttributes[i].children[j].caption[l] = $(this).closest('.technical-data-detail-editor').find('.language-' + l).val();
					}
				}
			}
			oAttribute = gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex];
			GOverlay.RemoveAll();
			gThis.m_oOptions.fSaveAttribute({
				attributeId: oAttribute.id,
				attributeName: oAttribute.caption,
				attributeType: oAttribute.type
			}, GCallback(gThis._OnAttributeSave, {
				iGroupIndex: iGroupIndex,
				iAttributeIndex: iAttributeIndex
			}));
			return false;
		}));
		var jDeleteButton = $('<a class="button delete" href="#"><span>' + GForm.Language.technical_data_delete_attribute_permanently + '</span></a>');
		jDeleteButton.click(GEventHandler(function(eEvent) {
			var iGroupIndex = $(this).closest('.technical-data-detail-editor').data('iGroupIndex');
			var iAttributeIndex = $(this).closest('.technical-data-detail-editor').data('iAttributeIndex');
			var sAttribute = gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].id;
			GOverlay.RemoveAll();
			GAlert(GForm.Language.technical_data_delete_attribute, GForm.Language.technical_data_delete_attribute_description, {
				aoPossibilities: [
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
							for (var i in gThis.m_oOptions.aTechnicalAttributes) {
								if (gThis.m_oOptions.aTechnicalAttributes[i].id == gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].id) {
									gThis.m_oOptions.aTechnicalAttributes.splice(i, 1);
									break;
								}
							}
							gThis.DeleteAttribute(iGroupIndex, iAttributeIndex);
							gThis.m_oOptions.fDeleteAttribute({
								attributeId: sAttribute
							}, GCallback(gThis._OnAttributeDeleted));
						}),
						sCaption: GMessageBar.Language.ok
					},
					{
						mLink: GEventHandler(function(eEvent) {
							GAlert.DestroyAll();
						}),
						sCaption: GMessageBar.Language.cancel
					}
				]
			});
		}));
		jOverlay.append(jSaveButton).append(jDeleteButton);
	});
	
	gThis._OnAttributeDeleteClick = GEventHandler(function(eEvent) {
		gThis.DeleteAttribute($(this).closest('.attribute').data('iGroupIndex'), $(this).closest('.attribute').data('iAttributeIndex'));
		gThis.m_bSetAltered = true;
		return false;
	});
	
	gThis._OnAttributeChange = GEventHandler(function(eEvent) {
		gThis.m_bSetAltered = true;
		var iGroupIndex = $(this).closest('.attribute').data('iGroupIndex');
		var iAttributeIndex = $(this).closest('.attribute').data('iAttributeIndex');
		var bFound = false;
		for (var k in gThis.m_oOptions.aTechnicalAttributes) {
			if (gThis.m_oOptions.aTechnicalAttributes[k].caption[GCore.iActiveLanguage] == $(this).val()) {
				bFound = true;
				break;
			}
		}
		if (bFound) {
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].id = gThis.m_oOptions.aTechnicalAttributes[k].id;
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].type = gThis.m_oOptions.aTechnicalAttributes[k].type;
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = '';
			for (var l in GCore.aoLanguages) {
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].caption[l] = (gThis.m_oOptions.aTechnicalAttributes[k].caption[l] == undefined) ? '' : gThis.m_oOptions.aTechnicalAttributes[k].caption[l];
			}
		}
		else {
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].id = 'new-' + GFormTechnicalDataEditor.s_iNewId++;
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].type = GFormTechnicalDataEditor.FIELD_STRING;
			gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = '';
			for (var l in GCore.aoLanguages) {
				if (l == GCore.iActiveLanguage) {
					gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].caption[l] = $(this).val();
					continue;
				}
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].caption[l] = '';
			}
			gThis.m_oOptions.aTechnicalAttributes.push(gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex]);
		}
		gThis._UpdateValueField(gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex], $(this).closest('.attribute'));
		gThis.UpdateFields();
	});
	
	gThis._UpdateValueField = function(oAttribute, jAttribute) {
		
		var jValue = jAttribute.find('.value').empty();
		switch (oAttribute.type) {
			case GFormTechnicalDataEditor.FIELD_STRING:
				gThis._WriteValueTypeString(jValue);
				break;
			case GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING:
				gThis._WriteValueTypeMultilingualString(jValue);
				break;
			case GFormTechnicalDataEditor.FIELD_TEXT:
				gThis._WriteValueTypeTextArea(jValue);
				break;
			case GFormTechnicalDataEditor.FIELD_IMAGE:
				gThis._WriteValueTypeImage(jValue);
				break;
			case GFormTechnicalDataEditor.FIELD_BOOLEAN:
				gThis._WriteValueTypeBoolean(jValue);
				break;
			case GFormTechnicalDataEditor.FIELD_SELECT:
				gThis._WriteValueTypeSelect(jValue);
				break;
		}
	};
	
	gThis._WriteValueTypeString = function(jTarget) {
		var jInput = $('<input type="text"/>');
		jInput.focus(GEventHandler(function(eEvent) {
			$(this).closest('.field').addClass('focus');
		})).blur(GEventHandler(function(eEvent) {
			$(this).closest('.field').removeClass('focus');
		}));
		var jInputNode = $('<div class="field-text"><span class="field"/></div>').append($('<span class="suffix"/>')).find('.field').append(jInput);
		jTarget.append(jInputNode.parent());
		jInput.change(gThis._OnChangeValue);
	};
	
	gThis._WriteValueTypeSelect = function(jTarget) {
		var jInput = $('<input type="text"/>');
		jInput.focus(GEventHandler(function(eEvent) {
			$(this).closest('.field').addClass('focus');
		})).blur(GEventHandler(function(eEvent) {
			$(this).closest('.field').removeClass('focus');
		}));
		var jInputNode = $('<div class="field-text"><span class="field"/></div>').append($('<span class="suffix"/>')).find('.field').append(jInput);
		jTarget.append(jInputNode.parent());
		jInput.change(gThis._OnChangeValue);
	};
	
	gThis._WriteValueTypeImage = function(jTarget) {
		gThis.m_jFileSelector = $('<div style="clear: both; padding-top: 10px;"/>');
		gThis.m_jSelectedFileName = $('<span class="filename"/>');
		gThis.m_jFileSelector.append(gThis.m_jSelectedFileName);
		gThis.m_jSwfUpload = $('<div class="' + gThis._GetClass('AddFiles') + '"/>').append('<span id="' + gThis.GetId() + '__upload"/>');
		gThis.m_jFileSelector.append(gThis.m_jSwfUpload);
		gThis.m_jChooseButton = $('<a href="#" class="button"><span><img src="' + gThis._GetImage('ChooseIcon') + '" alt=""/>' + GForm.Language.localfile_select + '</span></a>');
		gThis.m_jFileSelector.append($('<span class="browse-pictures"/>').append(gThis.m_jChooseButton));
		gThis.m_jQueue = $('<ul class="' + gThis._GetClass('Queue') + '"/>');
		gThis.m_jFileSelector.append(gThis.m_jQueue);
		gThis.m_jFilesDatagrid = $('<div/>');
		gThis.m_jFileSelector.append(gThis.m_jFilesDatagrid);
		gThis.m_jSelectedFiles = $('<div class="' + gThis._GetClass('SelectedTable') + '"/>');
		gThis.m_jFileSelector.append(gThis.m_jSelectedFiles);
		gThis.m_jFileField = $('<input type="hidden" name="' + gThis.GetName() + '[file]"/>');
		gThis.m_jFileSelector.append(gThis.m_jFileField);
		jTarget.append(gThis.m_jFileSelector);
	};
	
	gThis._WriteValueTypeTextArea = function(jTarget) {
		var jInput = $('<textarea rows="5" cols="5" style="width: 485px;" />');
		jInput.focus(GEventHandler(function(eEvent) {
			$(this).closest('.field').addClass('focus');
		})).blur(GEventHandler(function(eEvent) {
			$(this).closest('.field').removeClass('focus');
		}));
		var jInputNode = $('<div class="field-textarea"><span class="field"/></div>').append($('<span class="suffix"/>')).find('.field').append(jInput);
		jTarget.append(jInputNode.parent());
		jInput.change(gThis._OnChangeValue);
	};
	
	gThis._WriteValueTypeMultilingualString = function(jTarget) {
		var jInput = $('<input type="text"/>');
		jInput.focus(GEventHandler(function(eEvent) {
			$(this).closest('.field').addClass('focus');
		})).blur(GEventHandler(function(eEvent) {
			$(this).closest('.field').removeClass('focus');
		}));
		var jEdit = $('<img class="edit" src="' + gThis._GetImage('EditIcon') + '" alt="' + GForm.Language.technical_data_edit_multilingual_value + '" title="' + GForm.Language.technical_data_edit_multilingual_value + '"/>');
		jEdit.click(GEventHandler(function(eEvent) {
			var iGroupIndex = $(this).closest('.attribute').data('iGroupIndex');
			var iAttributeIndex = $(this).closest('.attribute').data('iAttributeIndex');
			var oAttribute = gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex];
			var jOverlay = $('<div class="technical-data-detail-editor"/>').data('iGroupIndex', iGroupIndex).data('iAttributeIndex', iAttributeIndex);
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
				var jLanguage = $('<div class="field-text"><span class="prefix"><img src="' + GCore.DESIGN_PATH + 'images/languages/' + GCore.aoLanguages[l].flag + '" alt="' + GCore.aoLanguages[l].name + '"/></span><span class="field"><input class="language-' + l + '" type="text" value="' + (((oAttribute.value == undefined) || (oAttribute.value[l] == undefined)) ? '' : oAttribute.value[l]) + '"/></span></div>');
				jOverlay.append(jLanguage);
			}
			var jSaveButton = $('<a class="button wide" href="#"><span>' + GForm.Language.technical_data_save_attribute + '</span></a>');
			jSaveButton.click(GEventHandler(function(eEvent) {
				var iAttributeIndex = $(this).closest('.technical-data-detail-editor').data('iAttributeIndex');
				var iGroupIndex = $(this).closest('.technical-data-detail-editor').data('iGroupIndex');
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = {};
				for (var l in GCore.aoLanguages) {
					gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value[l] = $(this).closest('.technical-data-detail-editor').find('.language-' + l).val();
				}
				gThis.UpdateValues();
				GOverlay.RemoveAll();
				return false;
			}));
			jOverlay.append(jSaveButton);
		}));
		var jInputNode = $('<div class="field-text"><span class="field"/></div>').append($('<span class="suffix"/>').append(jEdit)).find('.field').append(jInput);
		jTarget.append(jInputNode.parent());
		jInput.change(gThis._OnChangeValue);
	};
	
	gThis._WriteValueTypeBoolean = function(jTarget) {
		var jInput = $('<input type="checkbox"/>');
		var jInputNode = $('<div class="field-checkbox"><span class="field"/></div>').find('.field').append(jInput);
		jTarget.append(jInputNode.parent());
		jInput.change(gThis._OnChangeValue);
	};
	
	gThis._OnChangeValue = GEventHandler(function(eEvent) {
		var iGroupIndex = $(this).closest('.attribute').data('iGroupIndex');
		var iAttributeIndex = $(this).closest('.attribute').data('iAttributeIndex');
		switch (gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].type) {
			case GFormTechnicalDataEditor.FIELD_STRING:
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = $(this).val();
				break;
			case GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING:
				if (!(gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value instanceof Object)) {
					gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = {};
				}
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value[GCore.iActiveLanguage] = $(this).val();
				break;
			case GFormTechnicalDataEditor.FIELD_TEXT:
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = $(this).val();
				break;
			case GFormTechnicalDataEditor.FIELD_IMAGE:
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = $(this).val();
				break;
			case GFormTechnicalDataEditor.FIELD_BOOLEAN:
				gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].value = $(this).is(':checked');
				break;
		}
		gThis.UpdateFields();
	});
	
	gThis.UpdateValues = function() {
		for (var i in gThis.m_aoAttributes) {
			for (var j in gThis.m_aoAttributes[i].children) {
				if (gThis.m_aoAttributes[i].children[j].value != undefined) {
					gThis._UpdateValue(i, j, gThis.m_aoAttributes[i].children[j].value);
				}
			}
		}
		gThis.UpdateFields();
	};
	
	gThis._UpdateValue = function(iGroupIndex, iAttributeIndex, mValue) {
		switch (gThis.m_aoAttributes[iGroupIndex].children[iAttributeIndex].type) {
			case GFormTechnicalDataEditor.FIELD_STRING:
				gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value input:text').val(mValue);
				break;
			case GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING:
				gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value input:text').val(mValue[GCore.iActiveLanguage]);
				break;
			case GFormTechnicalDataEditor.FIELD_TEXT:
				gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value textarea').val(mValue);
				break;
			case GFormTechnicalDataEditor.FIELD_IMAGE:
				gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value input:text').val(mValue);
				break;
			case GFormTechnicalDataEditor.FIELD_BOOLEAN:
				if (Number(mValue)) {
					gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value').checkCheckboxes();
				}
				else {
					gThis.m_jAttributes.find('.group:eq(' + iGroupIndex + ') .attribute:eq(' + iAttributeIndex + ') .value').unCheckCheckboxes();
				}
				break;
		}
	};
	
	gThis._OnAttributeGroupSave = GEventHandler(function(eEvent) {
		gThis.m_aoAttributes[eEvent.iGroupIndex].id = eEvent.attributeGroupId;
		GMessage(GForm.Language.technical_data_save_group_success, GForm.Language.technical_data_save_group_success_description);
		var bFound = false;
		for (var i in gThis.m_oOptions.aAttributeGroups) {
			if (gThis.m_oOptions.aAttributeGroups[i].id == eEvent.attributeGroupId) {
				gThis.m_oOptions.aAttributeGroups[i] = $.extend({}, gThis.m_aoAttributes[eEvent.iGroupIndex]);
				bFound = true;
				break;
			}
		}
		if (!bFound) {
			gThis.m_oOptions.aAttributeGroups.push($.extend({}, gThis.m_aoAttributes[eEvent.iGroupIndex]));
		}
		gThis._WriteTechnicalAttributes();
	});
	
	gThis._OnAttributeGroupDeleted = GEventHandler(function(eEvent) {
		GMessage(GForm.Language.technical_data_delete_group_success, GForm.Language.technical_data_delete_group_success_description);
		gThis._WriteTechnicalAttributes();
	});
	
	gThis._OnAttributeSave = GEventHandler(function(eEvent) {
		gThis.m_aoAttributes[eEvent.iGroupIndex].children[eEvent.iAttributeIndex].id = eEvent.attributeId;
		GMessage(GForm.Language.technical_data_save_attribute_success, GForm.Language.technical_data_save_attribute_success_description);
		var bFound = false;
		for (var i in gThis.m_oOptions.aTechnicalAttributes) {
			if (gThis.m_oOptions.aTechnicalAttributes[i].id == eEvent.attributeId) {
				gThis.m_oOptions.aTechnicalAttributes[i] = $.extend({}, gThis.m_aoAttributes[eEvent.iGroupIndex].children[eEvent.iAttributeIndex]);
				bFound = true;
				break;
			}
		}
		if (!bFound) {
			gThis.m_oOptions.aTechnicalAttributes.push($.extend({}, gThis.m_aoAttributes[eEvent.iGroupIndex].children[eEvent.iAttributeIndex]));
		}
		gThis._WriteTechnicalAttributes();
	});
	
	gThis._OnAttributeDeleted = GEventHandler(function(eEvent) {
		GMessage(GForm.Language.technical_data_delete_attribute_success, GForm.Language.technical_data_delete_attribute_success_description);
		gThis._WriteTechnicalAttributes();
	});
	
	gThis._UpdateIndices = function() {
		gThis.m_jAttributes.children('.group').each(function(i) {
			$(this).data('iGroupIndex', i);
			$(this).find('.attribute').each(function(j) {
				$(this).data('iAttributeIndex', j);
				$(this).data('iGroupIndex', $(this).closest('.group').data('iGroupIndex'));
			});
		});
	};
	
}, oDefaults);

GFormTechnicalDataEditor.FIELD_STRING = 1;
GFormTechnicalDataEditor.FIELD_MULTILINGUAL_STRING = 2;
GFormTechnicalDataEditor.FIELD_TEXT = 3;
GFormTechnicalDataEditor.FIELD_IMAGE = 4;
GFormTechnicalDataEditor.FIELD_BOOLEAN = 5;
GFormTechnicalDataEditor.FIELD_SELECT = 6;
//GFormTechnicalDataEditor.FIELD_MULTISELECT = 7;

GFormTechnicalDataEditor.s_iNewId = 0;