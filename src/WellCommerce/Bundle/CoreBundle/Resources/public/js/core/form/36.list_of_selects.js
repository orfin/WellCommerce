/*
* LIST OF SELECTS
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-select',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-field-repetition',
		sRemoveRepetitionClass: 'remove-field-repetition'
	},
	aoSelects: [],
	sDefault: '',
	aoRules: [],
	sComment: ''
};

var GFormListOfSelects = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_bResized = false;
	
	gThis.m_aoSelects = [];
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		return gThis._GetField(sRepetition).find('option:selected').attr('value');
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		var jField = gThis._GetField(sRepetition);
		jField.val(mValue);
		if ((jField.get(0) != undefined) && (jField.get(0).Update != undefined)) {
			jField.get(0).Update.apply(jField.get(0));
		}
	};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>');
		gThis.m_aoSelects = gThis.m_oOptions.aoSelects;
		gThis.UpdateSelects();
	};
	
	gThis.UpdateSelects = function() {
		gThis.m_jNode.empty();
		gThis.m_jField.empty();
		var iSelects = gThis.m_aoSelects.length;
		for (var i = 0; i < iSelects; i++) {
			gThis.m_jNode.append(gThis._AddField(gThis.m_aoSelects[i]));
		}
	};
	
	gThis.ReplaceSelects = function(aoSelects) {
		gThis.m_aoSelects = aoSelects;
		gThis.UpdateSelects();
		gThis.m_bShown = false;
		gThis.m_bResized = false;
		gThis.OnShow();
		gThis._InitializeEvents();
	};
	
	gThis._AddField = function(oSelect) {
		var jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label for="' + gThis.GetId() + '"/>');
		jLabel.text(oSelect.label);
		if ((oSelect.comment != undefined) && (oSelect.comment.length)) {
			jLabel.append(' <small>' + oSelect.comment + '</small>');
		}
		jNode.append(jLabel);
		var jField = $('<select name="' + gThis.GetName(oSelect.name) + '" id="' + gThis.GetId(oSelect.name) + '"/>');
		for (var i = 0; i < oSelect.options.length; i++) {
			var oOption = oSelect.options[i];
			jField.append('<option value="' + oOption.value + '"' + (((oSelect.default_value != undefined) && (oOption.value == oSelect.default_value)) ? ' selected="selected"' : '') + '>' + oOption.label + '</option>');
		}
		if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
			gThis.m_jField = gThis.m_jField.add(jField);
		}
		else {
			gThis.m_jField = jField;
		}
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		if (oSelect.prefix != undefined) {
			var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
			jPrefix.html(oSelect.prefix);
			jRepetitionNode.append(jPrefix);
		}
		jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
		if (oSelect.suffix != undefined) {
			var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
			jSuffix.html(oSelect.suffix);
			jRepetitionNode.append(jSuffix);
		}
		return jNode.append(jRepetitionNode);
	};
	
	gThis.OnInitRepetition = function(sRepetition) {
		if (!gThis.m_bShown) {
			return;
		}
		gThis._GetField(sRepetition).GSelect();
		var iSelects = gThis.m_aoSelects.length;
		for (var i = 0; i < iSelects; i++) {
			if (gThis.m_aoSelects[i].default_value != undefined) {
				gThis.m_jField.filter('[id$="' + gThis.m_aoSelects[i].name + '"]').val(gThis.m_aoSelects[i].default_value).triggerHandler('change');
			}
		}
	};
	
	gThis.OnShow = function() {
		gThis._UpdateRepetitionButtons();
		if (!gThis.m_bShown && gThis.m_bRepeatable) {
			gThis._InitializeEvents('new-0');
		}
		gThis.m_bShown = true;
		if (gThis.m_bRepeatable) {
			for (var i in gThis.m_oRepetitions) {
				if (!gThis.m_oRepetitions[i].m_bResized) {
					gThis.m_oRepetitions[i].m_bResized = true;
					gThis.OnInitRepetition(i);
				}
			}
		}
		else {
			if (!gThis.m_bResized) {
				gThis.m_bResized = true;
				gThis.OnInitRepetition();
			}
		}
	};
	
	gThis.OnFocus = function(eEvent) {
		$(eEvent.currentTarget).closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
		gThis._ActivateFocusedTab(eEvent);
	};
	
	gThis.OnBlur = function(eEvent) {
		$(eEvent.currentTarget).closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
	};
	
	gThis.Reset = function() {
		gThis.ReplaceSelects(gThis.m_oOptions.aoSelects);
		//gThis.m_jField.val(gThis.m_oOptions.sDefault).change();
	};
	
	gThis._InitializeEvents = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		if (gThis.m_bRepeatable && (sRepetition == undefined)) {
			return;
		}
		var jField = gThis._GetField(sRepetition);
		jField.focus(gThis.OnFocus);
		jField.blur(gThis.OnBlur);
		jField.each(function() {
			$(this).change(GEventHandler(function(eEvent) {
				gThis.Validate(false, this.sRepetition);
			}));
		});
		jField.keydown(function(eEvent) {
			var dSelect = this;
			setTimeout(function() {
				dSelect.Update();
			}, 50);
			return true;
		});
		if (gThis.m_jNode.closest('.statusChange').length) {
			gThis.OnShow();
		}
	};
	
}, oDefaults);