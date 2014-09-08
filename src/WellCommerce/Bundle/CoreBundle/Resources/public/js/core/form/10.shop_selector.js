/*
* LAYER SELECTOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-tree',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sItemNameClass: 'item-name',
		sExpanderClass: 'expander',
		sExpandedClass: 'expanded',
		sActiveClass: 'active',
		sButtonClass: 'button',
		sExpandAllClass: 'expand-all',
		sRetractAllClass: 'retract-all'
	},
	oImages: {
		sAdd: 'images/icons/buttons/add.png',
		sDelete: 'images/icons/buttons/delete.png',
		sSave: 'images/icons/buttons/save.png',
		sRestore: 'images/icons/buttons/clean.png',
		sWaiting: 'images/icons/loading/indicator.gif'
	},
	aoOptions: [],
	sDefault: '',
	aoRules: [],
	sComment: '',
	oStores: {},
	sActive: ''
};

var GFormShopSelector = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_jTree;
	gThis.m_jOptions;
	gThis.m_oStores;
	gThis.m_jExpandAll;
	gThis.m_jRetractAll;
	gThis.m_jFieldWrapper;
	gThis.m_jItemPlaceholder;
	gThis.m_jItemDragged;
	gThis.m_oStores = {};
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jField = $('<input type="hidden"/>');
		gThis.m_jNode.append(gThis.m_jField);
		gThis.m_jFieldWrapper = $('<div/>');
		gThis.m_jNode.append(gThis.m_jFieldWrapper);
		gThis.m_jNode.append('<label>' + gThis.m_oOptions.sLabel + '</label>');
		gThis.m_jExpandAll = $('<a href="#"/>').text(GForm.Language.tree_expand_all);
		gThis.m_jRetractAll = $('<a href="#"/>').text('Zaznacz wszystkie');
		gThis.m_jTree = $('<ul/>');
		gThis.m_jNode.append($('<div class="tree-wrapper"/>').append(gThis.m_jTree));
		gThis.Update();
		window.setTimeout(gThis.ResetExpansion, 500);
	};

	gThis.OnRetractAll = function(eEvent) {
		gThis.m_jTree.find('li:has(li)').removeClass(gThis._GetClass('Expanded'));
		return false;
	};
	
	gThis.OnExpandAll = function(eEvent) {
		gThis.m_jTree.find('li:has(li)').addClass(gThis._GetClass('Expanded'));
		return false;
	};
	
	gThis.GetOrder = function() {
		var jItems = gThis.m_jTree.find('li');
		var aoItems = [];
		for (var i = 0; i < jItems.length; i++) {
			var sId = jItems.eq(i).get(0).sId;
			var sParent = '';
			if (jItems.eq(i).parent().closest('li').length) {
				sParent = jItems.eq(i).parent().closest('li').get(0).sId;
			}
			var jSiblings = jItems.eq(i).parent().children('li');
			var iWeight = jSiblings.length - jSiblings.index(jItems.eq(i)) - 1;
			aoItems.push({
				id: sId,
				parent: sParent,
				weight: iWeight
			});
		}
		return aoItems;
	};
	
	gThis.GetValue = function(sRepetition) {
		
		return gThis.m_jFieldWrapper.find('input:first').attr('value');
		
		if (gThis.m_jField == undefined) {
			return '';
		}
		var aValues = [];
		var jValues = gThis._GetField(sRepetition).filter(':checked');
		for (var i in jValues) {
			aValues.push(jValues.eq(i).attr('value'));
		}
		return aValues;
	};
	
	gThis.SetValue = function(mValue, sRepetition) {
		if (gThis.m_jField == undefined) {
			return;
		}
		gThis._GetField(sRepetition).val(mValue).change();
	};
	
	gThis.ResetExpansion = function() {
		gThis.m_jTree.find('li').removeClass(gThis._GetClass('Expanded'));
		gThis.m_jTree.find('li.' + gThis._GetClass('Active')).parents('li').andSelf().filter(':has(li)').addClass(gThis._GetClass('Expanded'));
		gThis.m_jTree.find('li > label > input:checked').parents('li').andSelf().filter(':has(li)').addClass(gThis._GetClass('Expanded'));
	};
	
	gThis._WriteSubtree = function(jParent, sParent) {
		if (sParent == undefined) {
			sParent = null;
		}
		var oStores = GCore.FilterObject(gThis.m_oOptions.oStores, function(oStore) {return (oStore.parent == sParent);});
		var aIterationArray = GCore.GetIterationArray(oStores, function(oA, oB) {return (oA.weight < oB.weight);});
		var iLength = aIterationArray.length;
		for (var i = 0; i < iLength; i++) {
			var sId = aIterationArray[i];
			var oStore = oStores[sId];
			jParent.append(gThis._WriteItem(sId, oStore));
		}
	};
	
	gThis._WriteItem = function(sId, oStore) {
		var jLi = $('<li/>');
		jLi.get(0).sId = sId;
		if (gThis.m_oOptions.sActive == sId) {
			jLi.addClass(gThis._GetClass('Active'));
		}
		
		if(oStore.type == 'store'){
			
			jLi.append($('<label class="' + gThis._GetClass('ItemName') + '"/>').css({'font-size':'13px','font-weight':'bold'}).append(oStore.name));
		
		}else{
			var jField = $('<input type="checkbox" value="' + sId + '"/>');	
			if (gThis.m_jFieldWrapper.find('input[value="' + sId + '"]').length) {
				jField.click();
				jField.attr('checked', 'checked');
			}
			if((gThis.m_oOptions.bGlobal == true) && GCore.iActiveView > 0){
				jField.attr('disabled','disabled');
			}
			jLi.append($('<label class="' + gThis._GetClass('ItemName') + '"/>').append(jField).append(oStore.name));
		}
		

		var jUl = $('<ul/>');
		gThis._WriteSubtree(jUl, sId);
		jLi.append(jUl);
		return jLi;
	};
	
	gThis.UpdateExpanders = function() {
		gThis.m_jTree.find('li::not(:has(li))').removeClass(gThis._GetClass('Expanded')).children('.' + gThis._GetClass('Expander')).css('display', 'none');
		gThis.m_jTree.find('li:has(li) > .' + gThis._GetClass('Expander')).css('display', 'block');
	};
	
	gThis.Update = function() {
		gThis.m_jTree.empty();
		gThis._WriteSubtree(gThis.m_jTree);
		gThis._InitializeNodeEvents();
		gThis.ResetExpansion();
	};
	
	gThis.Populate = function(mValue) {
		
		if ((mValue == undefined) || (mValue == '')) {
			mValue = [];
		}
		else if (!(mValue instanceof Array)) {
			mValue = [mValue];
		}
		
			gThis.m_jNode.unCheckCheckboxes();
			gThis.m_jFieldWrapper.empty();
			for (var i in mValue) {
				if (i == 'toJSON') {
					continue;
				}
				
				gThis.m_jFieldWrapper.append('<input type="hidden" name="' + gThis.GetName() + '[]" value="' + mValue[i] + '"/>');
				gThis.m_jNode.find('input:checkbox[value="v' + mValue[i] + '"]').parent().checkCheckboxes();
			}

		gThis.ResetExpansion();
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
			gThis.m_bShown = true;
		}
		gThis.OnExpandAll();
	};
	
	gThis._OnClick = GEventHandler(function(eEvent) {
		GCore.StartWaiting();
	});
	
	gThis._InitializeEvents = function(sRepetition) {
		gThis.m_jExpandAll.click(gThis.OnExpandAll);
		gThis.m_jRetractAll.click(gThis.OnRetractAll);
		gThis._InitializeNodeEvents();
	};
	
	gThis._OnSelect = GEventHandler(function(eEvent) {
		
		var sStoreLabel = $(this).attr('value');
		
		var oStores = GCore.FilterObject(gThis.m_oOptions.oStores, function(oStore) {
			return (oStore.label == sStoreLabel);
		});
		
		var aoStore = oStores[sStoreLabel];
		var iStoreId = aoStore['id'];
		
		gThis.m_jFieldWrapper.find('input[value="' + iStoreId + '"]').remove();

		if ($(this).is(':checked')) {
			
			var jInput = $('<input type="hidden" name="' + gThis.GetName() + '[]" value="' + iStoreId + '"/>');
			gThis.m_jFieldWrapper.append(jInput);
			
		}
	});
	
	gThis._InitializeNodeEvents = function() {
		gThis.m_jTree.find('.' + gThis._GetClass('Expander')).unbind('click').click(function() {
			if ($(this).closest('li').hasClass(gThis._GetClass('Expanded'))) {
				$(this).closest('li').find('li').andSelf().removeClass(gThis._GetClass('Expanded'));
			}
			else {
				$(this).closest('li').addClass(gThis._GetClass('Expanded'));
				gThis._Expand($(this).closest('li'));
			}
		});
		gThis.m_jTree.find('input').unbind('click').click(gThis._OnSelect);
	};
	
	gThis._Expand = function(jParentLi) {
		var sId = jParentLi.get(0).sId;
		if (gThis.m_oStores[sId] != undefined) {
			return;
		}
	};
	
	gThis._OnChildrenLoaded = GEventHandler(function(eEvent) {
		var jUl = $('<ul/>');
		gThis.m_oStores[eEvent.parentNode.get(0).sId] = true;
		for (var i in eEvent.children) {
			jUl.append(gThis._WriteItem(i, eEvent.children[i]));
		}
		eEvent.parentNode.find('ul').remove();
		eEvent.parentNode.append(jUl);
		gThis._InitializeNodeEvents();
	});
	
}, oDefaults);