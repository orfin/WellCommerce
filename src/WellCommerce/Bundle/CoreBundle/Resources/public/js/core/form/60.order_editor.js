/*
* ORDER EDITOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-order-editor',
		sFieldSpanClass: 'field',
		sGroupClass: 'group',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sHiddenClass: 'hidden',
		sButtonClass: 'button',
		sTriggerClass: 'trigger'
	},
	oImages: {
		sAddIcon: 'images/icons/buttons/add.png',
		sDeselectIcon: 'images/icons/datagrid/delete.png'
	},
	aoOptions: [],
	sDefault: '',
	aoRules: [],
	sComment: '',
	fLoadProducts: GCore.NULL,
	bAdvancedEditor: false
};

var GFormOrderEditor = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	
	gThis.m_fLoadProducts;
	gThis.m_fProcessProduct;
	gThis.m_jDatagrid;
	gThis.m_jSelectedDatagrid;
	gThis.m_jTrigger;
	gThis.m_gDatagrid;
	gThis.m_gSelectedDatagrid;
	gThis.m_gDataProvider;
	gThis.m_bFirstLoad = true;
	
	gThis.m_oRequest = {};
	
	gThis.m_iCounter = 0;
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		var aValues = [];
		var jValues = gThis.m_jField.find('input');
		for (var i = 0; i < jValues.length / 4; i++) {
			aValues.push({
				id: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[id]"]:eq(' + i + ')').val(),
				quantity: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[quantity]"]:eq(' + i + ')').val(),
				price: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[price]"]:eq(' + i + ')').val(),
				variant: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[variant]"]:eq(' + i + ')').val(),
				trackstock: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[trackstock]"]:eq(' + i + ')').val(),
				stock: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[stock]"]:eq(' + i + ')').val(),
				weight: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[weight]"]:eq(' + i + ')').val(),
			});
		}
		return aValues;
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		for (var i in mValue) {
			if (mValue[i]['id'] == undefined) {
				continue;
			}
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][idproduct]" value="' + mValue[i]['idproduct'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][quantity]" value="' + mValue[i]['quantity'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][previousquantity]" value="' + mValue[i]['previousquantity'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][trackstock]" value="' + mValue[i]['trackstock'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][stock]" value="' + mValue[i]['stock'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][sellprice]" value="' + mValue[i]['sellprice'] + '"/>');
			gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][variant]" value="' + mValue[i]['variant'] + '"/>');
		}
	};
	
	gThis._OnSelect = function(gDg, sId) {
		if (gThis.m_bRepeatable) {
			var oSelectedRow = GCore.Duplicate(gDg.GetRow(sId));
			gThis._AddRow(oSelectedRow);
			gDg.ClearSelection();
			gThis.m_gSelectedDatagrid.LoadData();
		}
	};
	
	gThis._AddRow = function(oSelectedRow) {
		GAlert.DestroyAll();
		GMessage('Dodano wybrany produkt do zamówienia.');
		oSelectedRow = $.extend({
			id: 'new-' + (gThis.m_iCounter++),
			quantity: 1,
			variant: '',
			sellprice: '0.00'
		}, oSelectedRow);
		gThis.m_gDataProvider.AddRow(oSelectedRow);
		return oSelectedRow;
	};
	
	gThis._OnDeselect = function(gDg, sId) {
	};
	
	gThis._OnChange = function(eEvent) {
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
		}
		var asIds = [];
		for (var i in eEvent.rows) {
			if (eEvent.rows[i].id != undefined) {
				asIds.push(eEvent.rows[i]);
			}
		}
		gThis.SetValue(asIds);
	};
	
	gThis._PrepareNode = function() {
		gThis.m_oOptions.oParsedFilterData = {};
		for (var i in gThis.m_oOptions.oFilterData) {
			$.globalEval('var oParsed = [' + gThis.m_oOptions.oFilterData[i] + '];');
			gThis.m_oOptions.oParsedFilterData[i] = $.extend({}, oParsed);
		}
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jDatagridWrapper = $('<div class="existing-products"/>');
		if (gThis.m_bRepeatable) {
			gThis.m_jField = $('<div/>');
			gThis.m_jDatagrid = $('<div/>');
			gThis.m_jDatagridWrapper.append(gThis.m_jDatagrid);
			gThis.m_jSelectedDatagrid = $('<div class="selected-products"/>');
			gThis.m_jNode.append(gThis.m_jDatagridWrapper);
			gThis.m_jNode.append(gThis.m_jSelectedDatagrid);
		}
		else {
			gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '"/>');
			gThis.m_jDatagrid = $('<div/>');
			gThis.m_jNode.append(gThis.m_jDatagridWrapper);
		}
		gThis.m_jNode.append(gThis.m_jField);
		gThis.m_jDatagridWrapper.addClass(gThis._GetClass('Hidden'));
		gThis.m_jTrigger = $('<p class="' + gThis._GetClass('Trigger') + '"/>');
		var jA = $('<a href="#" class="' + gThis._GetClass('Button') + '"/>');
		jA.append('<span><img src="' + gThis._GetImage('AddIcon') + '" alt=""/>' + GForm.Language.product_select_add + '</span>');
		jA.click(GEventHandler(function(eEvent) {
			var jImg = gThis.m_jTrigger.find('a span img');
			if (gThis.m_jDatagridWrapper.hasClass(gThis._GetClass('Hidden'))) {
				gThis.m_jDatagridWrapper.css('display', 'none').removeClass(gThis._GetClass('Hidden'));
			}
			if (!gThis.m_jDatagridWrapper.get(0).bHidden) {
				gThis.m_jDatagridWrapper.get(0).bHidden = true;
				gThis.m_jTrigger.find('a span').empty().append(jImg).append(GForm.Language.product_select_close_add);
			}
			else {
				gThis.m_jDatagridWrapper.get(0).bHidden = false;
				gThis.m_jTrigger.find('a span').empty().append(jImg).append(GForm.Language.product_select_add);
			}
			gThis.m_jDatagridWrapper.slideToggle(250);
			return false;
		}));
		gThis.m_jTrigger.append(jA);
		gThis.m_jNode.append(gThis.m_jTrigger);
	};
	
	gThis.OnReset = function() {
		gThis.m_bFirstLoad = true;
	};
	
	gThis.Populate = function(mValue) {
		if (!gThis.m_gDatagrid) {
			return;
		}
		gThis.m_jField.empty();
		gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
		gThis.SetValue(mValue);
		gThis.m_gSelectedDatagrid.LoadData();
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
			gThis._InitDatagrid();
			if (gThis.m_bRepeatable) {
				gThis._InitSelectedDatagrid();
				gThis.Populate(gThis.m_oOptions.asDefaults);
			}
			else {
				gThis.Populate(gThis.m_oOptions.sDefault);
			}
			gThis.m_bShown = true;
		}
	};
	
	gThis._ProcessProduct = function(oProduct) {
		return oProduct;
	};
	
	gThis._ProcessSelectedProduct = function(oProduct) {
		oProduct = gThis.m_fProcessProduct(oProduct);
		if (oProduct.thumb != '') {
			oProduct.name = '<a title="" href="' + oProduct.thumb + '" class="show-thumb"><img src="' + GCore.DESIGN_PATH + 'images/icons/datagrid/details.png" style="vertical-align: middle;" /></a> '+ oProduct.name + ((oProduct.ean != '') ? '<br /><small>EAN: ' + oProduct.ean + '</small>' : '');
		}else{
			oProduct.name = '<img style="opacity: 0.2;vertical-align: middle;" src="' + GCore.DESIGN_PATH + 'images/icons/datagrid/details.png" style="vertical-align: middle;" /> '+ oProduct.name + ((oProduct.ean != '') ? '<br /><small>EAN: ' + oProduct.ean + '</small>' : '');
		}
		return oProduct;
	};
	
	gThis._InitColumns = function() {
		
		var column_id = new GF_Datagrid_Column({
			id: 'idproduct',
			caption: GForm.Language.product_select_id,
			appearance: {
				width: 40,
				visible: false
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_name = new GF_Datagrid_Column({
			id: 'name',
			caption: GForm.Language.product_select_name,
			appearance: {
				align: GF_Datagrid.ALIGN_LEFT,
				width: GF_Datagrid.WIDTH_AUTO,
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_price = new GF_Datagrid_Column({
			id: 'sellprice',
			caption: GForm.Language.product_select_price,
			appearance: {
				width: 90
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_weight = new GF_Datagrid_Column({
			id: 'weight',
			caption: 'Waga',
			appearance: {
				width: 70
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_producer = new GF_Datagrid_Column({
			id: 'producer',
			caption: GForm.Language.product_select_producer,
			appearance: {
				width: 150
			},
			filter: {
				type: GF_Datagrid.FILTER_SELECT,
				options: gThis.m_oOptions.oParsedFilterData['producer'],
			}
		});
		
		var column_category = new GF_Datagrid_Column({
			id: 'categoriesname',
			caption: GForm.Language.product_select_categories,
			appearance: {
				width: 200,
				align: GF_Datagrid.ALIGN_LEFT
			},
			filter: {
				type: GF_Datagrid.FILTER_TREE,
				filtered_column: 'ancestorcategoryid',
				options: gThis.m_oOptions.oParsedFilterData['categoryid'],
				load_children: gThis.m_oOptions.fLoadCategoryChildren
			}
		});
		
		return [
			column_id,
			column_name,
			column_category,
			column_producer,
			column_price,
			column_weight,
		];
		
	};
	
	gThis._InitAdvancedColumns = function() {
		
		var column_id = new GF_Datagrid_Column({
			id: 'id',
			caption: GForm.Language.product_select_id,
			appearance: {
				width: 40,
				visible: false
			}
		});
		
		var column_idproduct = new GF_Datagrid_Column({
			id: 'idproduct',
			caption: GForm.Language.product_select_product_id,
			appearance: {
				width: 40,
				visible: false
			}
		});
		
		var column_name = new GF_Datagrid_Column({
			id: 'name',
			caption: GForm.Language.product_select_name,
			appearance: {
				align: GF_Datagrid.ALIGN_LEFT
			}
		});
		
		var column_barcode = new GF_Datagrid_Column({
			id: 'barcode',
			caption: GForm.Language.product_select_barcode,
			appearance: {
				width: 60,
				visible: false
			}
		});
		
		var column_variant = new GF_Datagrid_Column({
			id: 'variant',
			caption: GForm.Language.product_select_variant,
			selectable: true,
			appearance: {
				width: 140
			}
		});
		
		var column_price = new GF_Datagrid_Column({
			id: 'sellprice',
			caption: GForm.Language.product_select_price,
			editable: true,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_RIGHT
			}
		});
		
		var column_price_gross = new GF_Datagrid_Column({
			id: 'sellprice_gross',
			caption: GForm.Language.product_select_price_gross,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_weight = new GF_Datagrid_Column({
			id: 'weight',
			caption: 'Waga',
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_weight_total = new GF_Datagrid_Column({
			id: 'weight_total',
			caption: 'Waga w sumie',
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER,
				visible: false
			}
		});
		
		var column_quantity = new GF_Datagrid_Column({
			id: 'quantity',
			caption: GForm.Language.product_select_quantity,
			editable: true,
			appearance: {
			width: 50
		}
		});
		
		var column_stock = new GF_Datagrid_Column({
			id: 'stock',
			caption: GForm.Language.product_variants_editor_stock,
			appearance: {
				width: 80
			}
		});
		
		var column_net_subsum = new GF_Datagrid_Column({
			id: 'net_subsum',
			caption: GForm.Language.product_select_net_subsum,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_vat = new GF_Datagrid_Column({
			id: 'vat',
			caption: GForm.Language.product_select_vat,
			appearance: {
				width: 50,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_vat_value = new GF_Datagrid_Column({
			id: 'vat_value',
			caption: GForm.Language.product_select_vat_value,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_subsum = new GF_Datagrid_Column({
			id: 'subsum',
			caption: GForm.Language.product_select_subsum,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_CENTER
			}
		});
		
		var column_variant_options = new GF_Datagrid_Column({
			id: 'variant_options',
			caption: 'Warianty',
			appearance: {
				width: 70,
				visible: false
			}
		});
		
		return [
			column_id,
			column_idproduct,
			column_name,
			column_barcode,
			column_variant,
			column_price,
			column_price_gross,
			column_weight,
			column_weight_total,
			column_quantity,
			column_stock,
			column_net_subsum,
			column_vat,
			column_vat_value,
			column_subsum,
			column_variant_options
		];
		
	};
	
	gThis._InitDatagrid = function() {
		
		gThis.m_fProcessProduct = gThis._ProcessProduct;
		gThis.m_fLoadProducts = gThis.m_oOptions.fLoadProducts;
		var aoColumns = gThis._InitColumns();
		
    var oOptions = {
			id: gThis.GetId(),
			appearance: {
				column_select: false
			},
			mechanics: {
				rows_per_page: 15,
				key: 'idproduct',
				only_one_selected: !gThis.m_bRepeatable,
				no_column_modification: true,
				persistent: false
			},
			event_handlers: {
				load: gThis.m_fLoadProducts,
				process: gThis.m_fProcessProduct,
				select: gThis._OnSelect,
				deselect: gThis._OnDeselect//,
			},
			columns: aoColumns
    };
    
    gThis.m_gDatagrid = new GF_Datagrid(gThis.m_jDatagrid, oOptions);
		
	};
	
	gThis._Deselect = function(iDg, mId) {
		if (!(mId instanceof Array)) {
			mId = [mId];
		}
		for (var i = 0; i < mId.length; i++) {
			gThis.m_gDataProvider.DeleteRow(mId[i]);
		}
		gThis.m_gSelectedDatagrid.ClearSelection();
		gThis.m_gSelectedDatagrid.LoadData();
	};
	
	gThis._CalculateRow = function(oRow) {
		oRow.quantity = isNaN(parseFloat(oRow.quantity)) ? 0 : parseFloat(oRow.quantity);
		oRow.sellprice = oRow.sellprice.replace(/,/, '.');
		oRow.sellprice = isNaN(parseFloat(oRow.sellprice)) ? 0 : parseFloat(oRow.sellprice);
		oRow.vat = isNaN(parseFloat(oRow.vat)) ? 0 : parseFloat(oRow.vat);
		var fPrice = parseFloat(oRow.sellprice);
		oRow.net_subsum = oRow.quantity * oRow.sellprice;
		oRow.weight_total = oRow.quantity * oRow.weight;
		oRow.sellprice_gross = oRow.sellprice * (1 + (oRow.vat / 100));
		oRow.sellprice_gross = oRow.sellprice_gross.toFixed(2);
		oRow.vat_value = oRow.net_subsum * (oRow.vat / 100);
		oRow.subsum = (oRow.net_subsum + oRow.vat_value).toFixed(2);
		oRow.sellprice = oRow.sellprice.toFixed(4);
		oRow.net_subsum = oRow.net_subsum.toFixed(2);
		oRow.weight_total = oRow.weight_total.toFixed(2);
		oRow.vat = oRow.vat.toFixed(2) + '%';
		oRow.vat_value = oRow.vat_value.toFixed(2);
		return oRow;
	};
	
	gThis._CalculateTotal = function(aoRows) {
		var net_subsum = 0;
		var vat_value = 0;
		var subsum = 0;
		var weight = 0;
		for (var i in aoRows) {
			net_subsum += parseFloat(aoRows[i].net_subsum);
			vat_value += parseFloat(aoRows[i].vat_value);
			subsum += parseFloat(aoRows[i].subsum);
			weight += parseFloat(aoRows[i].weight_total);
		}
		return {
			name: 'Suma',
			net_subsum: net_subsum.toFixed(2),
			vat_value: vat_value.toFixed(2),
			subsum: subsum.toFixed(2),
			weight: weight.toFixed(2),
		};
	};
	
	gThis._OnRowChange = GEventHandler(function(eEvent) {
		if ((eEvent.modified_row.variant != eEvent.previous_row.variant) && (eEvent.modified_row.variant != '')) {
			eval('var aoVariants = ' + eEvent.modified_row.variant__options + ';');
			for (var i in aoVariants) {
				if (aoVariants[i].id == eEvent.modified_row.variant) {
					eEvent.modified_row.sellprice = aoVariants[i].options.price;
					eEvent.modified_row.weight = aoVariants[i].options.weight;
					eEvent.modified_row.stock = aoVariants[i].options.stock;
					eEvent.modified_row.thumb = aoVariants[i].options.thumb;
					eEvent.modified_row.ean = aoVariants[i].options.ean;
				}
			}
		}
	});
	
	gThis._InitSelectedDatagrid = function() {
		
		gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
			key: 'id',
			preProcess: gThis._CalculateRow,
			additional_rows: [
				new GF_Datagrid_Row({
					id: 'total',
					className: 'total',
					source: gThis._CalculateTotal,
					caption: GForm.Language.product_select_sum
				})
			],
			event_handlers: {
				change: gThis._OnChange,
				row_change: gThis._OnRowChange
			}
		}, []);
		
		var aoColumns = gThis._InitAdvancedColumns();
		
		var gActionDeselect = new GF_Action({
			img: gThis._GetImage('DeselectIcon'),
			caption: GForm.Language.product_select_deselect,
			action: gThis._Deselect
		});
		
    var oOptions = {
			id: gThis.GetId() + '_selected',
			appearance: {
				column_select: false,
				footer: false,
				filter: false
			},
			mechanics: {
				rows_per_page: 99999,
				key: 'id',
				no_column_modification: true,
				persistent: false
			},
			event_handlers: {
				load: function(oRequest, sResponseHandler) {
					if (gThis.m_bFirstLoad) {
						gThis.m_bFirstLoad = false;
						gThis._LoadSelected(oRequest, sResponseHandler);
					}
					else {
						gThis.m_gDataProvider.Load(oRequest, sResponseHandler);
					}
				},
				update_row: function(sId, oRow) {
					gThis.m_gDataProvider.UpdateRow(sId, oRow);
					gThis.m_gSelectedDatagrid.LoadData();
				},
				process: gThis._ProcessSelectedProduct,
				loaded: gThis.m_oOptions.fOnChange
			},
			columns: aoColumns,
			row_actions: [
				gActionDeselect
			],
			context_actions: [
				gActionDeselect
			],
			group_actions: [
				gActionDeselect
			]
    };
		
		gThis.m_gSelectedDatagrid = new GF_Datagrid(gThis.m_jSelectedDatagrid, oOptions);
		
	};
	
	gThis.AddProducts = function(mIds) {
		if (!(mIds instanceof Array)) {
			if (mIds == undefined) {
				return;
			}
			mIds = [mIds];
		}
		var oRequest = GCore.Duplicate(gThis.m_oRequest, true);
		oRequest.where = [{
			column: 'idproduct',
			value: mIds,
			operator: 'IN'
		}];
		gThis.m_fLoadProducts(oRequest, GCallback(function(eEvent) {
			for (var j in eEvent.rows) {
				gThis._AddRow(eEvent.rows[j]);
			}
			gThis.m_gSelectedDatagrid.LoadData();
		}));
	};
	
	gThis._LoadSelected = function(oRequest, sResponseHandler) {
		gThis.m_oRequest = oRequest;
		var asDefaults = [];
		for (var i in gThis.m_oOptions.asDefaults) {
			asDefaults.push(gThis.m_oOptions.asDefaults[i].idproduct);
		}
		oRequest.where = [{
			column: 'idproduct',
			value: asDefaults,
			operator: 'IN'
		}];
		gThis.m_fLoadProducts(oRequest, GCallback(function(eEvent) {
			var aoRows = [];
			for (var i in gThis.m_oOptions.asDefaults) {
				var sId = gThis.m_oOptions.asDefaults[i].idproduct;
				for (var j in eEvent.rows) {
					if (eEvent.rows[j].idproduct == sId) {
						aoRows.push($.extend(true, {id: i}, eEvent.rows[j], gThis.m_oOptions.asDefaults[i]));
						break;
					}
				}
			}
			gThis.m_gDataProvider.ChangeData(aoRows);
			gThis.m_gSelectedDatagrid.LoadData();
		}));
	};
	
}, oDefaults);