/*
* PRODUCT SELECT RELATED
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-product-select',
		sFieldSpanClass: 'field',
		sGroupClass: 'group',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition'
	},
	oImages: {
		sDeselectIcon: 'images/icons/datagrid/delete.png'
	},
	aoOptions: [],
	sDefault: '',
	aoRules: [],
	sComment: '',
	fLoadProducts: GCore.NULL,
};

var GFormProductSelectRelated = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	
	gThis.m_fLoadProducts;
	gThis.m_fProcessProduct;
	gThis.m_jDatagrid;
	gThis.m_jSelectedDatagrid;
	gThis.m_gDatagrid;
	gThis.m_gSelectedDatagrid;
	gThis.m_gDataProvider;
	gThis.m_bFirstLoad = true;
	gThis.m_aoExclude = [];
	gThis.m_sDependentSelector;
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		if (gThis.m_bRepeatable) {
			if (sRepetition != undefined) {
				return oValue = {
					id: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[id]"]').val(),
					hierarchy: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[hierarchy]"]').val(),
				};
			}
			var aValues = [];
			var jValues = gThis.m_jField.find('input');
			for (var i = 0; i < jValues.length / 3; i++) {
				aValues.push({
					id: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[id]"]:eq(' + i + ')').val(),
					hierarchy: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[hierarchy]"]:eq(' + i + ')').val(),
				});
			}
			return aValues;
		}
		else {
			return gThis.m_jField.val();
		}
	};
	
	gThis.PopulateErrors = function(mData) {
		if ((mData == undefined) || (mData == '')) {
			return;
		}
		gThis.SetError(mData);
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		if (gThis.m_bRepeatable) {
			for (var i in mValue) {
				if (i == 'toJSON') {
					continue;
				}
				
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName(i) + '[id]" value="' + mValue[i]['id'] + '"/>');
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName(i) + '[hierarchy]" value="' + mValue[i]['hierarchy'] + '"/>');
			}
		}
		else {
			gThis.m_bSkipValidation = true;
			gThis.m_jField.val(mValue).change();
			gThis.m_bSkipValidation = false;
		}
	};
	
	gThis._OnSelect = function(gDg, sId) {
		if (gThis.m_bRepeatable) {
			var oSelectedRow = gDg.GetRow(sId);
			oSelectedRow.hierarchy = 0;
			gThis.m_gDataProvider.AddRow(oSelectedRow);
			gThis.m_gSelectedDatagrid.LoadData();
		}
		else {
			gThis.SetValue(sId);
		}
	};
	
	gThis._OnDeselect = function(gDg, sId) {
		if (gThis.m_bRepeatable) {
			gThis.m_gDataProvider.DeleteRow(sId);
			gThis.m_gSelectedDatagrid.LoadData();
		}
		else {
			gThis.SetValue('');
		}
	};
	
	gThis._OnChange = function(eEvent) {
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
		}
		var aoData = [];
		for (var i in eEvent.rows) {
			if (i == 'toJSON') {
				continue;
			}
			
			aoData.push({
				id: eEvent.rows[i].idproduct,
				hierarchy: eEvent.rows[i].hierarchy,
			});
		}
		
		gThis.SetValue(aoData);
	};
	
	gThis._PrepareNode = function() {
		gThis.m_oOptions.oParsedFilterData = {};
		for (var i in gThis.m_oOptions.oFilterData) {
			$.globalEval('var oParsed = [' + gThis.m_oOptions.oFilterData[i] + '];');
			gThis.m_oOptions.oParsedFilterData[i] = $.extend({}, oParsed);
		}
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		var jLabel = $('<label/>');
		jLabel.text(gThis.m_oOptions.sLabel);
		if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
			jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
		}
		gThis.m_jNode.append(jLabel);
		if (gThis.m_bRepeatable) {
			gThis.m_jField = $('<div/>');
			gThis.m_jDatagrid = $('<div/>');
			jLabel = $('<label/>');
			jLabel.text(GForm.Language.product_select_selected + ':');
			gThis.m_jSelectedDatagrid = $('<div/>');
			gThis.m_jNode.append(gThis.m_jDatagrid);
			gThis.m_jNode.append(jLabel);
			gThis.m_jNode.append(gThis.m_jSelectedDatagrid);
		}
		else {
			gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '"/>');
			gThis.m_jDatagrid = $('<div/>');
			gThis.m_jNode.append(gThis.m_jDatagrid);
		}
		gThis.m_jNode.append(gThis.m_jField);
		if (gThis.m_oOptions.sExcludeFrom != undefined) {
			var gField = gThis.m_gForm.GetField(gThis.m_oOptions.sExcludeFrom);
			gField.m_sDependentSelector = gThis.m_oOptions.sName;
		}
	};
	
	gThis.OnReset = function() {
		gThis.m_bFirstLoad = true;
	};
	
	gThis.Populate = function(mValue) {
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
			if (gThis.m_gDatagrid) {
				gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
			}
		}
		else {
			gThis.m_oOptions.sDefault = mValue;
		}
		if (gThis.m_gDatagrid) {
			gThis._UpdateDatagridSelection(mValue);
		}
		gThis.SetValue(mValue);
		if (gThis.m_gDatagrid && gThis.m_bRepeatable) {
			gThis.m_gSelectedDatagrid.LoadData();
		}
	};
	
	gThis._UpdateDatagridSelection = function(mValue) {
		if (!(mValue instanceof Array)) {
			if ((mValue == undefined) || !mValue.length) {
				mValue = [];
			}
			else {
				mValue = [mValue];
			}
		}
		if (gThis.m_gDatagrid) {
			gThis.m_gDatagrid.m_asSelected = [];
			for (var i = 0; i < mValue.length; i++) {
				gThis.m_gDatagrid.m_asSelected[i] = mValue[i].id;
			}
		}
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
		else {
			gThis.m_gDatagrid.LoadData();
		}
	};
	
	gThis._ProcessProduct = function(oProduct) {
		if (oProduct.thumb != '') {
			oProduct.thumbpreview = '<a href="' + oProduct.thumb + '" ><img src="' + oProduct.thumb + '" style="vertical-align: middle;" alt="' + GForm.Language.file_selector_show_thumb + '"/></a>';
		}
		return oProduct;
	};
	
	gThis._ProcessSelectedProduct = function(oProduct) {
		oProduct = gThis.m_fProcessProduct(oProduct);
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
				width: 240
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_price = new GF_Datagrid_Column({
			id: 'sellprice',
			caption: GForm.Language.product_select_price,
			appearance: {
				width: 70,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_price_gross = new GF_Datagrid_Column({
			id: 'sellprice_gross',
			caption: GForm.Language.product_select_price_gross,
			appearance: {
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_buyprice = new GF_Datagrid_Column({
			id: 'buyprice',
			caption: GForm.Language.product_select_buyprice,
			appearance: {
				width: 70,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_buyprice_gross = new GF_Datagrid_Column({
			id: 'buyprice_gross',
			caption: GForm.Language.product_select_buyprice_gross,
			appearance: {
				width: 70,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_barcode = new GF_Datagrid_Column({
			id: 'barcode',
			caption: GForm.Language.product_select_barcode,
			appearance: {
				width: 150,
				visible: false
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
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
		
		var column_vat = new GF_Datagrid_Column({
			id: 'vat',
			caption: GForm.Language.product_select_vat,
			appearance: {
				width: 60,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_SELECT,
				options: gThis.m_oOptions.oParsedFilterData['vat'],
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
		
		var column_thumb = new GF_Datagrid_Column({
			id: 'thumbpreview',
			caption: GForm.Language.file_selector_thumb,
			appearance: {
				width: 30,
				no_title: true
			}
		});
		
		return [
			column_id,
			column_thumb,
			column_name,
			column_category,
			column_producer,
			column_price,
			column_price_gross,
			column_buyprice,
			column_buyprice_gross,
			column_barcode,
			column_vat,
		];
		
	};
	
	gThis._InitAdvancedColumns = function() {
		
		var column_id = new GF_Datagrid_Column({
			id: 'idproduct',
			caption: GForm.Language.product_select_id,
			appearance: {
				width: 40
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
				width: 240
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_price = new GF_Datagrid_Column({
			id: 'sellprice',
			caption: GForm.Language.product_select_price,
			appearance: {
				width: 70,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_price_gross = new GF_Datagrid_Column({
			id: 'sellprice_gross',
			caption: GForm.Language.product_select_price_gross,
			appearance: {
				width: 70,
				align: GF_Datagrid.ALIGN_RIGHT
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_barcode = new GF_Datagrid_Column({
			id: 'barcode',
			caption: GForm.Language.product_select_barcode,
			appearance: {
				width: 150,
				visible: false
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_producer = new GF_Datagrid_Column({
			id: 'producer',
			caption: GForm.Language.product_select_producer,
			appearance: {
				width: 150,
				visible: false
			}
		});
		
		var column_vat = new GF_Datagrid_Column({
			id: 'vat',
			caption: GForm.Language.product_select_vat,
			appearance: {
				width: 60,
				visible: false,
				align: GF_Datagrid.ALIGN_RIGHT
			}
		});
		
		var column_category = new GF_Datagrid_Column({
			id: 'categoriesname',
			caption: GForm.Language.product_select_categories,
			appearance: {
				width: 200,
				align: GF_Datagrid.ALIGN_LEFT,
				visible: false
			},
			filter: {
				type: GF_Datagrid.FILTER_TREE,
				filtered_column: 'ancestorcategoryid',
				options: gThis.m_oOptions.oParsedFilterData['categoryid'],
				load_children: gThis.m_oOptions.fLoadCategoryChildren
			}
		});
		
		var column_thumb = new GF_Datagrid_Column({
			id: 'thumbpreview',
			caption: GForm.Language.file_selector_thumb,
			appearance: {
				width: 30,
				no_title: true
			}
		});
		
		var column_hierarchy = new GF_Datagrid_Column({
			id: 'hierarchy',
			caption: GForm.Language.product_select_hierarchy,
			editable: true,
			appearance: {
				width: 70
			}
		});
		
		
		
		return [
		    column_id,
			column_thumb,
			column_name,
			column_category,
			column_price_gross,
			column_hierarchy,
			column_producer,
			column_vat,
			column_barcode,
		];
		
	};
	
	gThis._UpdateExcludes = function() {
		gThis.m_aoExclude = [];
		if (gThis.m_oOptions.sExcludeFrom != undefined) {
			var gField = gThis.m_gForm.GetField(gThis.m_oOptions.sExcludeFrom);
			gThis.m_aoExclude = [gField.GetValue()];
			if (!gThis.m_gDataProvider) {
				return;
			}
			for (var i in gThis.m_gDataProvider.m_aoData) {
				if (gThis.m_gDataProvider.m_aoData[i].idproduct == gField.GetValue()) {
					gThis.m_gDatagrid.DeselectRow(gThis.m_gDataProvider.m_aoData[i].idproduct);
					return;
				}
			}
		}
	};
	
	gThis._InitDatagrid = function() {
		
		gThis.m_fProcessProduct = gThis._ProcessProduct;
		gThis.m_fLoadProducts = gThis.m_oOptions.fLoadProducts;
		
		var aoColumns = gThis._InitColumns();
		var oOptions = {
			id: gThis.GetId(),
			mechanics: {
				rows_per_page: 10,
				key: 'idproduct',
				only_one_selected: !gThis.m_bRepeatable,
				no_column_modification: true,
				persistent: false
			},
			event_handlers: {
				load: function(oData, sProcessFunction) {
					gThis._UpdateExcludes();
					oData.dynamic_exclude = gThis.m_aoExclude;
					return gThis.m_fLoadProducts(oData, sProcessFunction);
				},
				process: gThis.m_fProcessProduct,
				select: gThis._OnSelect,
				deselect: gThis._OnDeselect,
				selection_changed: function() {
					if (gThis.m_sDependentSelector != undefined) {
						var gField = gThis.m_gForm.GetField(gThis.m_sDependentSelector);
						gField._UpdateExcludes();
					}
				}
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
			gThis.m_gDatagrid.DeselectRow(mId[i]);
		}
		gThis.m_gSelectedDatagrid.ClearSelection();
		gThis.m_gDatagrid.LoadData();
	};
	
	gThis._InitSelectedDatagrid = function() {
		
		gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
			key: 'idproduct',
			event_handlers: {
				change: gThis._OnChange
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
				filter: false
			},
			mechanics: {
				rows_per_page: 1000,
				key: 'idproduct',
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
				},
				process: gThis._ProcessSelectedProduct
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
	
	gThis._LoadSelected = function(oRequest, sResponseHandler) {
		var asDefaults = [];
		for (var i in gThis.m_oOptions.asDefaults) {
			asDefaults.push(gThis.m_oOptions.asDefaults[i].id);
		}
		oRequest.where = [{
			column: 'idproduct',
			value: asDefaults,
			operator: 'IN'
		}];
		
		gThis.m_fLoadProducts(oRequest, GCallback(function(eEvent) {
			for (var i in eEvent.rows) {
				var sId = eEvent.rows[i].idproduct;
				for (var j in gThis.m_oOptions.asDefaults) {
					if (gThis.m_oOptions.asDefaults[j].id == sId) {
						eEvent.rows[i].hierarchy = gThis.m_oOptions.asDefaults[j].hierarchy;
					}
				}
			}
			gThis.m_gDataProvider.ChangeData(eEvent.rows);
			gThis.m_gSelectedDatagrid.LoadData();
		}));
	};
	
}, oDefaults);