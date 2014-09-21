/*
* LAYOUT BOXES LIST
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	sComment: '',
	aoBoxes: [],
	oClasses: {
		sFieldClass: 'field-layout-boxes-list',
		sFieldTextClass: 'field-text',
		sFieldPriceClass: 'field-price',
		sFieldCheckboxClass: 'field-checkbox',
		sFieldSelectClass: 'field-select',
		sFieldSpanClass: 'field',
		sRangeColumnClass: 'price',
		sMinColumnClass: 'min',
		sMaxColumnClass: 'max',
		sOptionsColumnClass: 'options',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-field-repetition',
		sRemoveRepetitionClass: 'remove-field-repetition',
		sNetPriceClass: 'net-price',
		sGrossPriceClass: 'gross-price'
	},
	oImages: {
		sAdd: 'images/icons/buttons/add.png',
		sRemove: 'images/icons/buttons/delete.png'
	},
	sFieldType: 'text',
	sDefault: '',
	aoRules: [],
	sComment: ''
};

var GFormLayoutBoxesList = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_oBoxes = {};
	gThis.m_aBoxes = [];
	
	gThis.GetValue = function(sRepetition) {
		if (sRepetition == undefined) {
			var aoValues = [];
			var iLayoutBoxes = gThis.m_aBoxes.length;
			for (var i = 0; i < iLayoutBoxes; i++) {
				aoValues.push(gThis.GetValue(gThis.m_aBoxes[i]));
			}
			return aoValues;
		}
		else {
			var oBox = gThis.m_oBoxes[sRepetition];
			if (oBox == undefined) {
				return;
			}
			return {
				box: oBox.jBoxSelect.find('option:selected').attr('value'),
				span: isNaN(parseInt(oBox.jSpan.val())) ? 1 : parseInt(oBox.jSpan.val()),
				collapsed: oBox.jCollapsed.is(':checked')
			};
		}
	};
	
	gThis.Populate = function(mData) {
		while (gThis.m_aBoxes.length) {
			gThis.RemoveBox(gThis.m_aBoxes[0]);
		}
		gThis.SetValue(mData);
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (sRepetition == undefined) {
			if (mValue == '') {
				return;
			}
			for (var i in mValue) {
				gThis.SetValue(mValue[i], i);
			}
		}
		else {
			var oBox = gThis.m_oBoxes[sRepetition];
			if (oBox == undefined) {
				gThis.AddRepetition(sRepetition);
				oBox = gThis.m_oBoxes[sRepetition];
			}
			oBox.jSpan.val(mValue.span);
			if (mValue.collapsed == 1) {
				oBox.jCollapsed.parent().checkCheckboxes();
			}
			else {
				oBox.jCollapsed.parent().unCheckCheckboxes();
			}
			oBox.jBoxSelect.val(mValue.box).change();
		}
	};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label for="' + gThis.GetId() + '"/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
			jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jNode.append(jLabel);
	};

	gThis._AddField = function(sId) {
		var jBoxSelect = $('<select name="'+ gThis.GetName(sId) + '[layoutbox]" id="' + gThis.GetId(sId) + '__layoutbox"/>');
		var iLayoutBoxes = gThis.m_oOptions.aoBoxes.length;
		for (var i = 0; i < iLayoutBoxes; i++) {
			var oBox = gThis.m_oOptions.aoBoxes[i];
			jBoxSelect.append('<option value="' + oBox.value + '">' + oBox.label + '</option>');
		}
		var jSpan = $('<input type="text" name="'+ gThis.GetName(sId) + '[span]" id="' + gThis.GetId(sId) + '__span" value="1"/>');
		var jCollapsed = $('<input type="checkbox" name="'+ gThis.GetName(sId) + '[collapsed]" id="' + gThis.GetId(sId) + '__collapsed" value="1"/>');
		
		if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
			gThis.m_jField = gThis.m_jField.add(jBoxSelect);
		}
		else {
			gThis.m_jField = jBoxSelect;
		}
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		jRepetitionNode.append($('<span class="box-select"/>').append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jBoxSelect)));
		jRepetitionNode.append($('<span class="box-span"/>').append('<label for="' + gThis.GetId(sId) + '__span">' + GForm.Language.layout_boxes_list_span + '</label>').append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jSpan)));
		jRepetitionNode.append($('<span class="box-collapsed"/>').append($('<span class=""/>').append(jCollapsed)).append('<label for="' + gThis.GetId(sId) + '__collapsed">' + GForm.Language.layout_boxes_list_collapsed + '</label>'));
		
		gThis.m_oBoxes[sId] = {
			jBoxSelect: jBoxSelect,
			jSpan: jSpan,
			jCollapsed: jCollapsed,
			iPosition: GCore.ObjectLength(gThis.m_oBoxes)
		};
		gThis.m_aBoxes.push(sId);
		
		return jRepetitionNode;
	};
	
	gThis._UpdateIcons = function() {
		
		gThis.m_jNode.find('.icon').remove();
		
		var iLayoutBoxes = gThis.m_aBoxes.length;
		
		for (var i = 0; i < iLayoutBoxes; i++) {
			
			var oBox = gThis.m_oBoxes[gThis.m_aBoxes[i]];
			
			var jRemove = $('<a class="icon" href="#"/>');
			jRemove.append('<img src="' + gThis._GetImage('Remove') + '" alt="' + GForm.Language.layout_boxes_list_remove + '" title="' + GForm.Language.layout_boxes_list_remove + '"/>');
			oBox.jCollapsed.closest('.repetition').append(jRemove);
			jRemove.bind('click', {i:gThis.m_aBoxes[i]}, GEventHandler(function(eEvent) {
				gThis.RemoveBox(eEvent.data.i);
				return false;
			}));
			
		}
		
		var jAdd = $('<a class="add-box icon" href="#"/>');
		jAdd.append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.layout_boxes_list_add + '" title="' + GForm.Language.layout_boxes_list_add + '"/>');
		gThis.m_jNode.append(jAdd);
		jAdd.bind('click', GEventHandler(function(eEvent) {
			gThis.AddBox();
			return false;
		}));
	};
	
	gThis.RemoveBox = function(sId) {
		var oBox = gThis.m_oBoxes[sId];
		gThis.RemoveRepetition(sId);
		var iBoxes = gThis.m_aBoxes.length;
		for (var i = 0; i < iBoxes; i++) {
			if (gThis.m_aBoxes[i] == sId) {
				gThis.m_aBoxes.splice(i, 1);
				break;
			}
		}
		delete gThis.m_oBoxes[sId];
	};
	
	gThis.AddBox = function() {
		gThis.AddRepetition();
	};
	
	gThis._InitializeEvents = function(sRepetition) {
		if (sRepetition != undefined) {
			gThis.m_oBoxes[sRepetition].jBoxSelect.GSelect();
			gThis.m_oBoxes[sRepetition].jSpan.focus(GEventHandler(function(eEvent) {
				$(this).closest('.field').addClass('focus');
			})).blur(GEventHandler(function(eEvent) {
				$(this).closest('.field').removeClass('focus');
			}));
		}
		gThis._UpdateIcons();
	};
	
}, oDefaults);