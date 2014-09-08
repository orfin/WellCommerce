/*
* FAVOURITE CATEGORIES TREE
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
		sRetractAllClass: 'retract-all',
		sListClass: 'selected-list'
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
	bSortable: false,
	bSelectable: true,
	bChoosable: false,
	bClickable: false,
	bDeletable: false,
	oItems: {},
	fOnClick: GCore.NULL,
	fOnSaveOrder: GCore.NULL,
	fOnAdd: GCore.NULL,
	fOnAfterAdd: GCore.NULL,
	fOnDelete: GCore.NULL,
	fOnAfterDelete: GCore.NULL,
	sActive: '',
	sAddItemPrompt: '',
	bPreventDuplicates: true
};

var GFormFavouriteCategories = GCore.ExtendClass(GFormTree, function() {
	
	var gThis = this;
	
	gThis.m_bShown = false;
	gThis.m_jTree;
	gThis.m_jOptions;
	gThis.m_oItems;
	gThis.m_jExpandAll;
	gThis.m_jRetractAll;
	gThis.m_jFieldWrapper;
	gThis.m_jItemPlaceholder;
	gThis.m_jItemDragged;
	gThis.m_oItems = {};
	gThis.m_jList;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jFieldWrapper = $('<div/>');
		gThis.m_jNode.append(gThis.m_jFieldWrapper);
		gThis.m_jExpandAll = $('<a href="#"/>').text(GForm.Language.tree_expand_all);
		gThis.m_jRetractAll = $('<a href="#"/>').text(GForm.Language.tree_retract_all);
		gThis.m_jNode.append(gThis._CreateSelectedList());
		if (gThis.m_oOptions.fGetChildren instanceof Function) {
			gThis.m_jNode.append($('<p class="' + gThis._GetClass('ExpandAll') + '"/>').append(gThis.m_jRetractAll));
		}
		else {
			//gThis.m_jNode.append($('<p class="' + gThis._GetClass('ExpandAll') + '"/>').append(gThis.m_jExpandAll));
			gThis.m_jNode.append($('<p class="' + gThis._GetClass('RetractAll') + '"/>').append(gThis.m_jRetractAll));
		}
		gThis.m_jTree = $('<ul/>');
		gThis.m_jNode.append($('<div class="tree-wrapper"/>').append(gThis.m_jTree));
		gThis.Update();
		gThis._PrepareOptions();
		window.setTimeout(gThis.ResetExpansion, 500);
	};
	
	gThis._CreateSelectedList = function() {
		gThis.m_jList = $('<div/>').addClass(gThis._GetClass('List'));
		var jTable = $('<table cellspacing="0"/>');
		var jThead = $('<thead/>');
		var jTr = $('<tr/>');
		var i;
		for (i = 0; i < gThis.m_oOptions.aoColumns.length; i++) {
			jTr.append($('<th>' + gThis.m_oOptions.aoColumns[i].caption + '</th>').css('width', (gThis.m_oOptions.aoColumns[i].width != undefined) ? gThis.m_oOptions.aoColumns[i].width + 'px' : 'auto'));
		}
		jTr.append('<th style="width: 16px;">&nbsp;</th>');
		jThead.append(jTr);
		jTable.append(jThead);
		var jBody = $('<tbody/>');
		jTable.append(jBody);
		gThis.m_jList.append('<label>' + gThis.m_oOptions.sLabel + '</label>');
		gThis.m_jList.append(jTable);
		return gThis.m_jList;
	};
	
	gThis.OnShow = function() {
		if (!gThis.m_bShown) {
			gThis.m_bShown = true;
			var iSelected = gThis.m_jFieldWrapper.find('input').length;
			var fGetInfo = gThis.m_oOptions.fGetSelectedInfo;
			gThis.m_oOptions.fGetSelectedInfo = GCore.NULL;
			var asIds = [];
			for (var i = 0; i < iSelected; i++) {
				var sId = gThis.m_jFieldWrapper.find('input').eq(i).attr('value');
				gThis._AddToList(sId);
				asIds.push(sId);
				gThis.m_jList.find('tr.id__' + sId + ' td:first').html('<img src="' + gThis._GetImage('Waiting') + '" alt=""/>');
			};
			if (asIds.length) {
				fGetInfo({
					id: asIds
				}, GCallback(gThis._OnInfoLoaded));
			}
			gThis.m_oOptions.fGetSelectedInfo = fGetInfo;
		}
	};
	
	gThis._OnSelect = GEventHandler(function(eEvent) {
		gThis.m_jFieldWrapper.find('input[value="' + $(this).attr('value') + '"]').remove();
		if ($(this).is(':checked')) {
			gThis.m_jFieldWrapper.append('<input type="hidden" name="' + gThis.GetName() + '[]" value="' + $(this).attr('value') + '"/>');
			gThis._AddToList($(this).attr('value'));
		}
		else {
			gThis._RemoveFromList($(this).attr('value'));
		}
	});
	
	gThis._AddToList = function(sId) {
		if (gThis.m_jList.find('tr.id__' + sId).length) {
			return;
		}
		var jTr = $('<tr class="id__' + sId + '"/>');
		for (var i in gThis.m_oOptions.aoColumns) {
			var oColumn = gThis.m_oOptions.aoColumns;
			var jTd = $('<td/>');
			jTr.append(jTd);
		}
		jTd = $('<td/>');
		var jTrigger = $('<a href="#" title="' + GForm.Language.tree_deselect + '"/>');
		jTrigger.click(GEventHandler(function(eEvent) {
			var sId = $(this).closest('tr').attr('class').substr(4);
			gThis.m_jTree.find('input:checkbox[value="' + sId + '"]:checked').click();
			gThis.m_jFieldWrapper.find('input[value="' + sId + '"]').remove();
			gThis._RemoveFromList(sId);
			return false;
		}));
		jTrigger.append('<img src="' + gThis._GetImage('Delete') + '" alt="' + GForm.Language.tree_deselect + '"/>');
		jTd.append(jTrigger);
		jTr.append(jTd);
		if (gThis.m_oOptions.fGetSelectedInfo instanceof Function) {
			jTr.find('td:first').html('<img src="' + gThis._GetImage('Waiting') + '" alt=""/>');
			gThis.m_oOptions.fGetSelectedInfo({
				id: sId
			}, GCallback(gThis._OnInfoLoaded));
		}
		else {
			jTr.find('td:first').text(gThis.m_jTree.find('label:has(input:checkbox[value="' + sId + '"])').text());
		}
		gThis.m_jList.find('tbody').append(jTr);
	};
	
	gThis._OnInfoLoaded = GEventHandler(function(eEvent) {
		for (var j in eEvent.rows) {
			var jColumns = gThis.m_jList.find('tr.id__' + eEvent.rows[j].id + ' td');
			for (var i in gThis.m_oOptions.aoColumns) {
				if (eEvent.rows[j].values[i] != undefined) {
					jColumns.eq(i).html(eEvent.rows[j].values[i]);
				}
			}
		}
	});
	
	gThis._RemoveFromList = function(sId) {
		var jTr = gThis.m_jList.find('tr.id__' + sId);
		jTr.remove();
	};
	
}, oDefaults);