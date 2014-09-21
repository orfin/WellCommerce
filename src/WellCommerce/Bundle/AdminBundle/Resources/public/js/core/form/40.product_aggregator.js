/*
* PRODUCT AGGREGATOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-product-aggregator',
		sFieldPriceClass: 'field-price',
		sFieldConstantClass: 'field-text',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sNetPriceClass: 'net-price',
		sGrossPriceClass: 'gross-price'
	},
	sFieldType: 'text',
	sProductsSourceField: '',
	fLoadProductData: GCore.NULL
};

var GFormProductAggregator = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_jProducts;
	gThis.m_aoProducts = [];
	gThis.m_iLockId = -1;
	gThis.m_jNetSum;
	gThis.m_jGrossSum;
	gThis.m_jCount;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jProducts = $('<div/>');
		gThis.m_jNode.append(gThis._AddProductCount(0));
		gThis.m_jNode.append(gThis.m_jProducts);
		gThis.m_jNode.append(gThis._AddSummary(0, 0));
	};
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		return gThis.m_jField.eq(0).val();
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		return;
	};
	
	gThis._RewriteProducts = function() {
		gThis.m_jProducts.empty();
		var iCount = gThis.m_aoProducts.length;
		var fNetSum = 0;
		var fGrossSum = 0;
		for (var i = 0; i < iCount; i++) {
			var oProduct = gThis.m_aoProducts[i];
			var jProductRow = gThis._AddProduct(oProduct);
			fNetSum += isNaN(parseFloat(jProductRow.find('input:text:eq(0)').val())) ? 0 : parseFloat(jProductRow.find('input:text:eq(0)').val());
			fGrossSum += isNaN(parseFloat(jProductRow.find('input:text:eq(1)').val())) ? 0 : parseFloat(jProductRow.find('input:text:eq(1)').val());
			gThis.m_jProducts.append(jProductRow);
		}
		gThis._UpdateWidths();
		gThis.UpdateCount(iCount);
		gThis.UpdateSum(fNetSum, fGrossSum);
	};
	
	gThis.UpdateSum = function(fNetSum, fGrossSum) {
		gThis.m_jNetSum.val(fNetSum.toFixed(2)).change();
		gThis.m_jGrossSum.val(fGrossSum.toFixed(2));
	};
	
	gThis.UpdateCount = function(iCount) {
		gThis.m_jCount.val(iCount).change();
	};
	
	gThis._AddProductCount = function(iCount) {
		var jElement = $('<div/>').addClass(gThis._GetClass('FieldConstant'));
		var jLabel = $('<label/>').css('font-weight', 'bold');
		var sLabel = GForm.Language.product_aggregator_count;
		jLabel.text(sLabel);
		jElement.append(jLabel);
		var jField = $('<input type="' + gThis.m_oOptions.sFieldType + '" disabled="disabled" value="' + iCount + '"/>').css('cursor', 'default');
		var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
		jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
		jElement.append(jRepetitionNode);
		gThis.m_jCount = jField;
		return jElement;
	};
	
	gThis._AddSummary = function(fNetSum, fGrossSum) {
		var jElement = $('<div/>').addClass(gThis._GetClass('FieldPrice'));
		var jLabel = $('<label/>').css('font-weight', 'bold');
		var sLabel = GForm.Language.product_aggregator_sum;
		jLabel.text(sLabel);
		jElement.append(jLabel);
		var jFieldNet = $('<input disabled="disabled" type="text" name="' + gThis.GetName() + '" value="' + fNetSum.toFixed(2) + '"/>').css('cursor', 'default');
		gThis.m_jField = jFieldNet;
		var jFieldGross = $('<input disabled="disabled" type="text" value="' + fGrossSum.toFixed(2) + '"/>').css('cursor', 'default');
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
		jElement.append(jRepetitionNode);
		gThis.m_jNetSum = jFieldNet;
		gThis.m_jGrossSum = jFieldGross;
		return jElement;
	};
	
	gThis._AddProduct = function(oProduct) {
		var jElement = $('<div/>').addClass(gThis._GetClass('FieldPrice'));
		var jLabel = $('<label/>');
		var sLabel = oProduct.name;
		if (parseInt(oProduct.quantity) > 1) {
			sLabel = oProduct.quantity + ' ' + String.fromCharCode(0xd7) + ' ' + sLabel;
		}
		jLabel.text(sLabel);
		jElement.append(jLabel);
		jElement.append(gThis._AddPrice(oProduct));
		return jElement;
	};
	
	gThis._AddPrice = function(oProduct) {
		var jFieldNet = $('<input disabled="disabled" type="text" value="' + oProduct.sellprice + '"/>').css('cursor', 'default');
		var jFieldGross = $('<input disabled="disabled" type="text" value="' + oProduct.sellprice_gross + '"/>').css('cursor', 'default');
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
		//gThis.m_jField = jRepetitionNode.find('input');
		return jRepetitionNode;
	};
	
	gThis.OnShow = function() {
		gThis.m_bShown = true;
		gThis._UpdateWidths();
		gThis.Update();
	};
	
	gThis._UpdateWidths = function() {
		gThis.m_jNode.find('input:text').each(function(i) {
			if (i == 0) {
				return;
			}
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
	};
	
	gThis._CalculateGrossPrice = function(sPrice) {
		/*var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
		var iVatId = gVat.GetValue();
		var fVat = 0;
		for (var i in gThis.m_oOptions.aoVatValues) {
			if (gThis.m_oOptions.aoVatValues[i].id == iVatId) {
				fVat = gThis.m_oOptions.aoVatValues[i].value;
				break;
			}
		}
		if (sPrice == undefined) {
			var sPrice = gThis.m_jField.eq(0).val();
		}
		var fPrice = parseFloat(sPrice.replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		//gThis.m_jField.eq(0).val(fPrice.toFixed(2));
		gThis.m_jField.eq(1).val((fPrice * (1 + fVat / 100)).toFixed(2));*/
	};
	
	gThis._CalculateNetPrice = function(sPrice) {
		/*var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
		var iVatId = gVat.GetValue();
		var fVat = 0;
		for (var i in gThis.m_oOptions.aoVatValues) {
			if (gThis.m_oOptions.aoVatValues[i].id == iVatId) {
				fVat = gThis.m_oOptions.aoVatValues[i].value;
				break;
			}
		}
		if (sPrice == undefined) {
			var sPrice = gThis.m_jField.eq(0).val();
		}
		var fPrice = parseFloat(sPrice.replace(/,/, '.'));
		fPrice = isNaN(fPrice) ? 0 : fPrice;
		//gThis.m_jField.eq(1).val(fPrice.toFixed(2));
		gThis.m_jField.eq(0).val((fPrice / (1 + fVat / 100)).toFixed(2));*/
	};
	
	gThis.StartWaiting = function() {
		gThis.m_jNode.css('opacity', .5);
	};
	
	gThis.EndWaiting = function() {
		gThis.m_jNode.css('opacity', 1);
	};
	
	gThis.Update = function() {
		var jProducts = gThis.m_gForm.GetField(gThis.m_oOptions.sProductsSourceField).m_jField.find('input');
		gThis.m_iLockId = gThis.m_gForm.Lock(GForm.Language.product_aggregator_form_blocked, GForm.Language.product_aggregator_form_blocked_description);
		gThis.StartWaiting();
		var aoProducts = [];
		for (var i = 0; i < jProducts.length - 2; i += 3) {
			aoProducts.push({
				id: jProducts.eq(i + 0).attr('value'),
				quantity: jProducts.eq(i + 1).attr('value'),
				variant: jProducts.eq(i + 2).attr('value')
			});
		}
		gThis.m_oOptions.fLoadProductData({
			products: aoProducts
		}, GCallback(GEventHandler(function(eEvent) {
			gThis.m_aoProducts = eEvent.products;
			gThis._RewriteProducts();
			gThis.m_gForm.Unlock(gThis.m_iLockId);
			gThis.EndWaiting();
		})));
	};
	
	gThis.Reset = function() {
		gThis.Update();
	};
	
	gThis.Focus = function() {
		return false;
	};
	
}, oDefaults);