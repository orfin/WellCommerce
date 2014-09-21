/*
* CLIENT SELECT
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-client-select',
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
		sAddIcon: 'images/icons/buttons/add-customer.png',
		sDeselectIcon: 'images/icons/datagrid/delete.png'
	},
	aoOptions: [],
	sDefault: '',
	aoRules: [],
	sComment: '',
	fLoadClients: GCore.NULL,
	fLoadClientData: GCore.NULL
};

var GFormClientSelect = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	
	gThis.m_fLoadClients;
	gThis.m_fProcessProduct;
	gThis.m_jDatagrid;
	gThis.m_jDatagridWrapper;
	gThis.m_jTrigger;
	gThis.m_jSelectedDatagrid;
	gThis.m_gDatagrid;
	gThis.m_gSelectedDatagrid;
	gThis.m_gDataProvider;
	gThis.m_bFirstLoad = true;
	gThis.m_jClientName;
	gThis.m_jClientEmail;
	gThis.m_jClientGroup;
	gThis.m_aoAddresses = [];
	gThis.m_agListeners = [];
	
	gThis.m_bFirstLoad = true;
	
	gThis.GetValue = function(sRepetition) {
		if (gThis.m_jField == undefined) {
			return '';
		}
		if (gThis.m_bRepeatable) {
			if (sRepetition != undefined) {
				return gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '"]').val();
			}
			var aValues = [];
			var jValues = gThis.m_jField.find('input');
			for (var i = 0; i < jValues.length; i++) {
				aValues.push(jValues.eq(i).val());
			}
			return aValues;
		}
		else {
			return gThis.m_jField.val();
		}
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		if (gThis.m_bRepeatable) {
			for (var i in mValue) {
				gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName(i) + '" value="' + mValue[i] + '"/>');
			}
		}
		else {
			gThis.m_jField.val(mValue).change();
		}
	};
	
	gThis._OnDataLoaded = function(oData) {
		gThis.m_jClientName.text(oData.name);
		gThis.m_jClientEmail.text(oData.email);
		gThis.m_jClientGroup.text(oData.group);
		
		$('#address_data__billing_data__firstname').val(oData.billing_address.firstname);
		$('#address_data__billing_data__surname').val(oData.billing_address.surname);
		$('#address_data__billing_data__street').val(oData.billing_address.street);
		$('#address_data__billing_data__streetno').val(oData.billing_address.streetno);
		$('#address_data__billing_data__placeno').val(oData.billing_address.placeno);
		$('#address_data__billing_data__place').val(oData.billing_address.placename);
		$('#address_data__billing_data__postcode').val(oData.billing_address.postcode);
		$('#address_data__billing_data__companyname').val(oData.billing_address.companyname);
		$('#address_data__billing_data__nip').val(oData.billing_address.nip);
		$('#address_data__billing_data__email').val(oData.email);
		$('#address_data__billing_data__phone').val(oData.phone);
		
		$('#address_data__shipping_data__firstname').val(oData.delivery_address.firstname);
		$('#address_data__shipping_data__surname').val(oData.delivery_address.surname);
		$('#address_data__shipping_data__street').val(oData.delivery_address.street);
		$('#address_data__shipping_data__streetno').val(oData.delivery_address.streetno);
		$('#address_data__shipping_data__placeno').val(oData.delivery_address.placeno);
		$('#address_data__shipping_data__place').val(oData.delivery_address.placename);
		$('#address_data__shipping_data__postcode').val(oData.delivery_address.postcode);
		$('#address_data__shipping_data__companyname').val(oData.delivery_address.companyname);
		$('#address_data__shipping_data__nip').val(oData.delivery_address.nip);
		$('#address_data__shipping_data__email').val(oData.email);
		$('#address_data__shipping_data__phone').val(oData.phone);
		
		gThis.m_bFirstLoad = false;
	};
	
	gThis._OnSelect = function(gDg, sId) {
		gThis.SetValue(sId);
		gThis.m_oOptions.fLoadClientData({
			client: sId
		}, GCallback(gThis._OnDataLoaded));
	};
	
	gThis._OnDeselect = function(gDg, sId) {
		
	};
	
	gThis._OnChange = function(eEvent) {
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
		}
		var aoData = [];
		for (var i in eEvent.rows) {
			aoData.push({
				id: eEvent.rows[i].idproduct,
				quantity: eEvent.rows[i].quantity,
				variant: eEvent.rows[i].variant
			});
		}
		gThis.SetValue(aoData);
	};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '"/>');
		gThis.m_jDatagrid = $('<div/>');
		gThis.m_jNode.append(gThis.m_jField);
		gThis.m_jDatagridWrapper = $('<div class="existing-users"/>');
		gThis.m_jDatagridWrapper.append(gThis.m_jDatagrid);
		gThis.m_jNode.append(gThis.m_jDatagridWrapper);
		gThis.m_jDatagridWrapper.addClass(gThis._GetClass('Hidden'));
		gThis.m_jTrigger = $('<p class="' + gThis._GetClass('Trigger') + '"/>');
		
		var jA = $('<a href="#" id="__select" class="' + gThis._GetClass('Button') + '"/>');
		jA.append('<span><img src="' + gThis._GetImage('AddIcon') + '" alt=""/>' + GForm.Language.client_select_select_client + '</span>');
		jA.click(GEventHandler(function(eEvent) {
			var jImg = gThis.m_jTrigger.find('a#__select span img');
			if (gThis.m_jDatagridWrapper.hasClass(gThis._GetClass('Hidden'))) {
				gThis.m_jDatagridWrapper.css('display', 'none').removeClass(gThis._GetClass('Hidden'));
			}
			if (!gThis.m_jDatagridWrapper.get(0).bHidden) {
				gThis.m_gDatagrid.LoadData();
				gThis.m_jDatagridWrapper.get(0).bHidden = true;
				gThis.m_jTrigger.find('a#__select span').empty().append(jImg).append(GForm.Language.product_select_close_selection);
			}
			else {
				gThis.m_jDatagridWrapper.get(0).bHidden = false;
				gThis.m_jTrigger.find('a#__select span').empty().append(jImg).append(GForm.Language.client_select_select_client);
			}
			gThis.m_jDatagridWrapper.slideToggle(250);
			return false;
		}));
		
		var jAdd = $('<a style="margin-left: 20px;" href="#" class="' + gThis._GetClass('Button') + '"/>');
		jAdd.append('<span>' + GForm.Language.client_select_add_client + '</span>');
		jAdd.click(GEventHandler(function(eEvent) {
			if(gThis.m_jDatagridWrapper.get(0).bHidden){
				jA.click();
			}
			window.open(GCore.sAdminUrl + 'client/add');
		}));
		
		gThis.m_jTrigger.append(jA);
		gThis.m_jTrigger.append(jAdd);
		gThis.m_jNode.append(gThis.m_jTrigger);
		var jColumns = $('<div class="layout-two-columns"/>');
		var jLeftColumn = $('<div class="column"/>');
		jColumns.append(jLeftColumn);
		gThis.m_jClientName = $('<span class="constant"/>');
		jLeftColumn.append($('<div class="field-text"/>').append('<label>' + GForm.Language.client_select_client_name + '</label>').append($('<span class="repetition"/>').append(gThis.m_jClientName)));
		gThis.m_jClientEmail = $('<span class="constant"/>');
		jLeftColumn.append($('<div class="field-text"/>').append('<label>' + GForm.Language.client_select_client_email + '</label>').append($('<span class="repetition"/>').append(gThis.m_jClientEmail)));
		gThis.m_jClientGroup = $('<span class="constant"/>');
		jLeftColumn.append($('<div class="field-text"/>').append('<label>' + GForm.Language.client_select_client_group + '</label>').append($('<span class="repetition"/>').append(gThis.m_jClientGroup)));
		gThis.m_jNode.append(jColumns);
	};
	
	gThis.OnReset = function() {
		gThis.m_bFirstLoad = true;
	};
	
	gThis.Populate = function(mValue) {
		if (!gThis.m_gDatagrid) {
			return;
		}
		if (gThis.m_bRepeatable) {
			gThis.m_jField.empty();
			gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
		}
		else {
			gThis.m_oOptions.sDefault = mValue;
		}
		gThis._UpdateDatagridSelection(mValue);
		gThis.SetValue(mValue);
		if (gThis.m_bRepeatable) {
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
		gThis.m_gDatagrid.m_asSelected = [];
		for (var i = 0; i < mValue.length; i++) {
			gThis.m_gDatagrid.m_asSelected[i] = mValue[i];
		}
		if (gThis.m_bShown) {
			gThis.m_gDatagrid.LoadData();
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
			if (gThis.GetValue()) {
				gThis.m_oOptions.fLoadClientData({
					client: gThis.GetValue()
				}, GCallback(gThis._OnDataLoaded));
			}
		}
	};
	
	gThis._ProcessProduct = function(oProduct) {
		return oProduct;
	};
	
	gThis._ProcessSelectedProduct = function(oProduct) {
		oProduct = gThis.m_fProcessProduct(oProduct);
		return oProduct;
	};
	
	gThis._InitColumns = function() {
		
		var column_id = new GF_Datagrid_Column({
			id: 'idclient',
			caption: GForm.Language.client_select_id,
			appearance: {
				width: 90
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		var column_firstname = new GF_Datagrid_Column({
			id: 'firstname',
			caption: GForm.Language.client_select_first_name,
			appearance: {
				width: 200
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_surname = new GF_Datagrid_Column({
			id: 'surname',
			caption: GForm.Language.client_select_surname,
			appearance: {
				width: 200
			},
			filter: {
				type: GF_Datagrid.FILTER_INPUT
			}
		});
		
		var column_email = new GF_Datagrid_Column({
			id: 'email',
			caption: GForm.Language.client_select_email,
			appearance: {
				width: 180,
				visible: false
			}
		});
		
		var column_phone = new GF_Datagrid_Column({
			id: 'phone',
			caption: GForm.Language.client_select_phone,
			appearance: {
				width: 110,
				visible: false
			}
		});
		
		var column_group = new GF_Datagrid_Column({
			id: 'groupname',
			caption: GForm.Language.client_select_group
		});
		
		var column_adddate = new GF_Datagrid_Column({
			id: 'adddate',
			caption: GForm.Language.client_select_adddate,
			appearance: {
				width: 140,
				visible: false
			},
			filter: {
				type: GF_Datagrid.FILTER_BETWEEN
			}
		});
		
		return [
			column_id,
			column_surname,
			column_firstname,
			column_group,
			column_email,
			column_phone,
			column_adddate
		];
		
	};
	
	gThis._InitDatagrid = function() {
		
		gThis.m_fProcessProduct = gThis._ProcessProduct;
		gThis.m_fLoadClients = gThis.m_oOptions.fLoadClients;
		
		var aoColumns = gThis._InitColumns();
		
    var oOptions = {
			id: gThis.GetId(),
			mechanics: {
				rows_per_page: 15,
				key: 'idclient',
				only_one_selected: !gThis.m_bRepeatable,
				persistent: false
			},
			event_handlers: {
				load: gThis.m_fLoadClients,
				process: gThis.m_fProcessProduct,
				select: gThis._OnSelect,
				deselect: gThis._OnDeselect//,
				//selection_changed: gThis._OnChange
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
			key: 'idclient',
			event_handlers: {
				change: gThis._OnChange
			}
		}, []);
		
		var aoColumns = gThis._InitColumns();
		
		var gActionDeselect = new GF_Action({
			img: gThis._GetImage('DeselectIcon'),
			caption: GForm.Language.product_select_deselect,
			action: gThis._Deselect
		});
		
    var oOptions = {
			id: gThis.GetId() + '_selected',
			mechanics: {
				rows_per_page: 15,
				key: 'idclient',
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
		if (gThis.m_oOptions.bAdvancedEditor) {
			var asDefaults = [];
			for (var i in gThis.m_oOptions.asDefaults) {
				asDefaults.push(gThis.m_oOptions.asDefaults[i].id);
			}
			oRequest.where = [{
				column: 'idclient',
				value: asDefaults,
				operator: 'IN'
			}];
		}
		else {
			oRequest.where = [{
				column: 'idclient',
				value: gThis.m_oOptions.asDefaults,
				operator: 'IN'
			}];
		}
		gThis.m_fLoadClients(oRequest, GCallback(function(eEvent) {
			gThis.m_gDataProvider.ChangeData(eEvent.rows);
			gThis.m_gSelectedDatagrid.LoadData();
		}));
	};
	
	gThis.GetAddress = function(sAddress) {
		for (var i in gThis.m_aoAddresses) {
			if (gThis.m_aoAddresses[i]._id == sAddress) {
				return GCore.Duplicate(gThis.m_aoAddresses[i], true);
			}
		}
		return {};
	};
	
	gThis.AddListener = function(gNode) {
		gThis.m_agListeners.push(gNode);
	};
	
}, oDefaults);