/**
 * CSRF
 */
var GFormTextFieldCSRF = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_bResized = false;
	
	gThis._PrepareNode = function() {
		
		gThis.m_jNode = $('<div/>');
		
		if (!gThis.m_bRepeatable) {
			gThis.m_jNode.append(gThis._AddField());
		}
		else {
			gThis.AddRepetition();
		}
		
	};

	gThis._AddField = function(sId) {
		var jField = $('<input type="hidden" name="'+ gThis.GetName(sId) + '" id="' + gThis.GetId(sId) + '"/>');
		
		if ((gThis.m_jField instanceof $) && gThis.m_jField.length) {
			gThis.m_jField = gThis.m_jField.add(jField);
		}
		else {
			gThis.m_jField = jField;
		}
		
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
		
		var jError = $('<span class="' + gThis._GetClass('Required') + '"/>');
		jRepetitionNode.append(jError);
		gThis.jRepetitionNode = jRepetitionNode;
		
		return gThis.jRepetitionNode;
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
					var iWidth = parseInt(gThis._GetField(i).css('width'));
					if (gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Prefix')).length) {
						iWidth -= (gThis._GetField(i).offset().left - gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
					}
					if (gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Suffix')).length) {
						iWidth -= gThis.m_oRepetitions[i].find('.' + gThis._GetClass('Suffix')).width() + 4;
					}
					gThis._GetField(i).eq(i).css('width', iWidth);
				}
			}
		}
		else {
			if (!gThis.m_bResized) {
				gThis.m_bResized = true;
				var iWidth = parseInt(gThis.m_jField.css('width'));
				if (gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).length) {
					iWidth -= (gThis.m_jField.offset().left - gThis.m_jNode.find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
				}
				if (gThis.m_jNode.find('.' + gThis._GetClass('Suffix')).length) {
					iWidth -= gThis.m_jNode.find('.' + gThis._GetClass('Suffix')).width() + 4;
				}
				gThis.m_jField.css('width', iWidth);
			}
		}
	};
	
	gThis.OnFocus = function(eEvent) {
		var jField = $(eEvent.currentTarget);
		jField.closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
		gThis._ActivateFocusedTab(eEvent);
	};
	
	gThis.OnBlur = function(eEvent) {
		var jField = $(eEvent.currentTarget);
		jField.closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
	};
	
	gThis.Reset = function() {
		gThis.m_jField.val(gThis.m_oOptions.sDefault);
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
			$(this).unbind('change', gThis.OnValidate).change(gThis.OnValidate);
		});
		
	};
	
	
}, oDefaults);