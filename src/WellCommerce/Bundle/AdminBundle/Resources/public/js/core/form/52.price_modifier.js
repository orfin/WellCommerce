/*
* PRICE MODIFIER
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-price-modifier',
		sFieldPriceClass: 'field-price',
		sFieldSelectClass: 'field-select',
		sFieldTextClass: 'field-text',
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
		sNetPriceClass: 'net-price',
		sGrossPriceClass: 'gross-price'
	},
	oImages: {
		sAddRepetition: 'images/icons/buttons/add.png',
		sRemoveRepetition: 'images/icons/buttons/delete.png'
	},
	sFieldType: 'text',
	sDefault: '',
	aoRules: [],
	sComment: '',
	aoVatValues: [],
	oSuffixes: {},
	sVatField: '',
	sBasePriceField: ''
};

var GFormPriceModifier = GCore.ExtendClass(GFormPrice, function() {
	
	var gThis = this;
	gThis.m_jPrice;
	gThis.m_jModifier;
	gThis.m_jValue;
	gThis.m_jPriceFields;
	gThis.m_jModifierField;
	gThis.m_jValueField;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis._AddModifier();
		gThis._AddValue();
		gThis._AddPrice();
	};
	
	gThis._AddModifier = function() {
		gThis.m_jValue = $('<div/>').addClass(gThis._GetClass('FieldSelect'));
		var jLabel = $('<label for="' + gThis.GetId() + '__modifier"/>');
		jLabel.text(GForm.Language.price_modifier_value);
		gThis.m_jValue.append(jLabel);
		var jField = $('<select name="' + gThis.GetName() + '[modifier]" id="' + gThis.GetId() + '__modifier"/>');
		for (var i in gThis.m_oOptions.oSuffixes) {
			jField.append('<option value="' + i + '">' + gThis.m_oOptions.oSuffixes[i] + '</option>');
		}
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
		gThis.m_jValue.append(jRepetitionNode);
		gThis.m_jNode.append(gThis.m_jValue);
		gThis.m_jModifierField = jField;
	};
	
	gThis._AddValue = function() {
		gThis.m_jValue = $('<div/>').addClass(gThis._GetClass('FieldText'));
		var jLabel = $('<label for="' + gThis.GetId() + '__value"/>');
		jLabel.text(GForm.Language.price_modifier_value);
		gThis.m_jValue.append(jLabel);
		var jField = $('<input type="text" name="' + gThis.GetName() + '[value]" id="' + gThis.GetId() + '__value"/>');
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
		gThis.m_jValue.append(jRepetitionNode);
		gThis.m_jNode.append(gThis.m_jValue);
		gThis.m_jValueField = jField;
	};
	
	gThis._AddPrice = function() {
		gThis.m_jPrice = $('<div/>').addClass(gThis._GetClass('FieldPrice'));
		var jLabel = $('<label for="' + gThis.GetId() + '"__price/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
			jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jPrice.append(jLabel);
		gThis.m_jPrice.append(gThis._AddField());
		gThis.m_jNode.append(gThis.m_jPrice);
	};
	
	gThis.GetValue = function(sRepetition) {
		return {
			modifier: gThis.m_jModifierField.val(),
			value: gThis.m_jValueField.val()
		};
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		gThis.m_jModifierField.val(mValue['modifier']).change();
		gThis.m_jValueField.val(mValue['value']).change();
	};
	
	gThis._AddField = function(sId) {
		var jFieldNet = $('<input type="text" name="' + gThis.GetName() + '[price]" id="' + gThis.GetId() + '__price"/>');
		var jFieldGross = $('<input type="text" id="' + gThis.GetId() + '__gross"/>');
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		var jNetNode = $('<span class="' + gThis._GetClass('NetPrice') + '"/>');
		var jGrossNode = $('<span class="' + gThis._GetClass('GrossPrice') + '"/>');
		if (gThis.m_oOptions.asPrefixes[0] != undefined) {
			var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
			jPrefix.html(gThis.m_oOptions.asPrefixes[0]);
			jNetNode.append(jPrefix);
		}
		jNetNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
		if (gThis.m_oOptions.sSuffix != undefined) {
			var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
			jSuffix.html(gThis.m_oOptions.sSuffix);
			jNetNode.append(jSuffix);
		}
		if (gThis.m_oOptions.asPrefixes[1] != undefined) {
			var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
			jPrefix.html(gThis.m_oOptions.asPrefixes[1]);
			jGrossNode.append(jPrefix);
		}
		jGrossNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldGross));
		if (gThis.m_oOptions.sSuffix != undefined) {
			var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
			jSuffix.html(gThis.m_oOptions.sSuffix);
			jGrossNode.append(jSuffix);
		}
		jRepetitionNode.append(jNetNode).append(jGrossNode);
		gThis.m_jPriceFields = jRepetitionNode.find('input');
		return jRepetitionNode;
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
			gThis.m_jModifierField.GSelect();
		}
		gThis.m_bShown = true;
		if (!gThis.m_bResized) {
			gThis.m_bResized = true;
			gThis.m_jPriceFields.each(function() {
				var iWidth = Math.floor(parseInt($(this).css('width')) / 2) - 20;
				var jParent = $(this).closest('.' + gThis._GetClass('NetPrice') + ', .' + gThis._GetClass('GrossPrice'));
				if (jParent.find('.' + gThis._GetClass('Prefix')).length) {
					iWidth -= ($(this).offset().left - jParent.find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
				}
				if (jParent.find('.' + gThis._GetClass('Suffix')).length) {
					iWidth -= jParent.find('.' + gThis._GetClass('Suffix')).width() + 4;
				}
				$(this).css('width', iWidth);
			});
		}
	};
	
	gThis._CalculateGrossPrice = function(sPrice) {
		var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
		var iVatId = gVat.GetValue();
		var fVat = 0;
		for (var i in gThis.m_oOptions.aoVatValues) {
			if (gThis.m_oOptions.aoVatValues[i].id == iVatId) {
				fVat = gThis.m_oOptions.aoVatValues[i].value;
				break;
			}
		}
		if (sPrice == undefined) {
			var sPrice = gThis.m_jPriceFields.eq(0).val();
		}
		var fPrice = parseFloat(sPrice.replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		gThis.m_jPriceFields.eq(1).val((fPrice * (1 + fVat / 100)).toFixed(2));
	};
	
	gThis._CalculateNetPrice = function(sPrice) {
		var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
		var iVatId = gVat.GetValue();
		var fVat = 0;
		for (var i in gThis.m_oOptions.aoVatValues) {
			if (gThis.m_oOptions.aoVatValues[i].id == iVatId) {
				fVat = gThis.m_oOptions.aoVatValues[i].value;
				break;
			}
		}
		if (sPrice == undefined) {
			var sPrice = gThis.m_jPriceFields.eq(0).val();
		}
		var fPrice = parseFloat(sPrice.replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		gThis.m_jPriceFields.eq(0).val((fPrice / (1 + fVat / 100)).toFixed(2));
	};
	
	gThis._UpdatePrice = function(sModifier, fModifierValue) {
		if (sModifier == undefined) {
			sModifier = $('#' + gThis.GetId() + '__modifier option:selected').text();
		}
		if (fModifierValue == undefined) {
			fModifierValue = parseFloat($('#' + gThis.GetId() + '__value').val().replace(/,/, '.'));
		}
		else {
			fModifierValue = parseFloat(('' + fModifierValue).replace(/,/, '.'));
		}
		var fBasePrice = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sBasePriceField).GetValue().replace(/,/, '.'));
		fModifierValue = isNaN(fModifierValue) ? 0 : fModifierValue;
		fBasePrice = isNaN(fBasePrice) ? 0 : fBasePrice;
		var fPrice = 0;
		switch (sModifier) {
			case '%':
				fPrice = fBasePrice * (fModifierValue / 100);
				break;
			case '+':
				fPrice = fBasePrice + fModifierValue;
				break;
			case '-':
				fPrice = fBasePrice - fModifierValue;
				break;
			case '=':
				fPrice = fModifierValue;
				break;
		}
		$('#' + gThis.GetId() + '__price').val(fPrice.toFixed(2));
		var fVatvalue = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jNode.find('option:selected').text());
		fVatvalue = isNaN(fVatvalue) ? 0 : fVatvalue;
		var fGrossPrice = fPrice * (1 + fVatvalue / 100);
		$('#' + gThis.GetId() + '__gross').val(fGrossPrice.toFixed(2));
	};
	
	gThis._UpdateModificatorValue = function(fPrice) {
		var sModifier = $('#' + gThis.GetId() + '__modifier option:selected').text();
		if (fPrice == undefined) {
			fPrice = parseFloat($('#' + gThis.GetId() + '__price').val().replace(/,/, '.'));
		}
		else {
			fPrice = parseFloat(('' + fPrice).replace(/,/, '.'));
		}
		var fBasePrice = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sBasePriceField).GetValue().replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		fBasePrice = isNaN(fBasePrice) ? 0 : fBasePrice;
		var fModifierValue = 0;
		if (fBasePrice > 0) {
			switch (sModifier) {
				case '%':
					fModifierValue = (fPrice / fBasePrice) * 100;
					break;
				case '+':
					fModifierValue = fPrice - fBasePrice;
					break;
				case '-':
					fModifierValue = fBasePrice - fPrice;
					break;
				case '=':
					fModifierValue = fPrice;
					break;
			}
		}
		$('#' + gThis.GetId() + '__value').val(fModifierValue.toFixed(2));
	};
	
	gThis._Initialize = function() {
		var fHandler = GEventHandler(function(eEvent) {
			setTimeout(function() {
				gThis._CalculateGrossPrice($(eEvent.currentTarget).val());
				gThis._UpdateModificatorValue($(eEvent.currentTarget).val());
			}, 5);
		});
		gThis.m_jPriceFields.eq(0).keypress(fHandler).blur(fHandler).change(gThis.ValidateField);
		fHandler = GEventHandler(function(eEvent) {
			setTimeout(function() {
				gThis._CalculateNetPrice($(eEvent.currentTarget).val());
				gThis._UpdateModificatorValue();
			}, 5);
		});
		gThis.m_jPriceFields.eq(1).keypress(fHandler).blur(fHandler).change(gThis.ValidateField);
		gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jField.change(GEventHandler(function(eEvent) {
			gThis._CalculateGrossPrice();
		}));
		gThis.m_gForm.GetField(gThis.m_oOptions.sBasePriceField).m_jField.change(GEventHandler(function(eEvent) {
			gThis.UpdatePrices();
		}));
		gThis.m_jPriceFields.add(gThis.m_jValueField).focus(GEventHandler(function(eEvent) {
			$(this).closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
		})).blur(GEventHandler(function(eEvent) {
			$(this).closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
		}));
		gThis.m_jValueField.keypress(GEventHandler(function(eEvent) {
			setTimeout(function() {
				gThis.UpdatePrices(undefined, $(eEvent.currentTarget).val());
			}, 5);
		}));
		gThis.m_jModifierField.change(GEventHandler(function(eEvent) {
			gThis.UpdatePrices($(eEvent.currentTarget).find('option:selected').text());
		}));
		gThis.UpdatePrices();
	};
	
	gThis.UpdatePrices = function() {
		setTimeout(function() {
			gThis._UpdatePrice();
			gThis.m_jPriceFields.change();
		}, 5);
	};
	
	gThis.ValidateField = GEventHandler(function(eEvent) {
		var fPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		$(eEvent.currentTarget).val(fPrice.toFixed(2));
	});
	
	gThis.Reset = function() {
		gThis.m_jField.eq(0).val(gThis.m_oOptions.sDefault).change();
	};
	
}, oDefaults);