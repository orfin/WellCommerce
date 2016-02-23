/*
* QUICK ACCESS
*/

var oDefaults = {
	aoPossibilities: [],
	oClasses: {
		sExpandClass: 'expand',
		sExpandedClass: 'expanded',
		sActiveClass: 'active',
		sListClass: 'list',
		sPossibilitiesListClass: 'possibilities-list',
		sCustomizeClass: 'customize',
		sCustomizationClass: 'customization',
		sButtonClass: 'button',
		sCancelClass: 'cancel',
		sSaveClass: 'save',
		sAccessKeyClass: 'accesskey',
		sCaptionClass: 'caption',
		sHiddenClass: 'aural'
	},
	sCookieName: 'gekosale-panel-quick-access'
};

var GQuickAccess = function() {
	
	var gThis = this;
	
	gThis.m_jMainOption;
	gThis.m_jListTrigger;
	gThis.m_jCustomizationTrigger;
	gThis.m_jList;
	gThis.m_jCustomization;
	gThis.m_jPossibilitiesList;
	gThis.m_aList;
	gThis.m_aPossibilitiesList;
	
	gThis.m_bExpanded;
	gThis.m_bCustomization;
	
	gThis._Constructor = function() {
		gThis.m_bExpanded = false;
		gThis.m_bCustomization = false;
		gThis.m_aList = [];
		gThis.m_aPossibilitiesList = gThis.m_oOptions.aoPossibilities;
		gThis._PrepareDOM();
	};
	
	gThis._PrepareDOM = function() {
		gThis._PrepareList();
		gThis._PreparePossibilitiesList();
		gThis.m_jMainOption = $('<p/>');
		gThis.m_jList.before(gThis.m_jMainOption);
		gThis._UpdateMainOption();
		gThis.m_jListTrigger = $('<span class="' + gThis.m_oOptions.oClasses.sExpandClass + '" title="' + GQuickAccess.Language.show_list + '"/>');
		var fToggleClass = 
		gThis.m_jListTrigger.hover(function() {
			gThis.m_jMainOption.addClass(gThis.m_oOptions.oClasses.sActiveClass);
		}, function() {
			if (!gThis.m_bExpanded) {
				gThis.m_jMainOption.removeClass(gThis.m_oOptions.oClasses.sActiveClass);
			}
		}).mousedown(gThis.OnExpandList);
		$(gThis).mouseleave(gThis.OnRetractList);
		gThis.m_jMainOption.append(gThis.m_jListTrigger);
		gThis._RefreshAccessKeys();
	};
	
	gThis._SaveList = function() {
		GCookie(gThis.m_oOptions.sCookieName, gThis.m_aList.join(','), {
			expires: GCore.p_oParams.iCookieLifetime
		});
	};
	
	gThis._PrepareList = function() {
		var i;
		var sCookie = GCookie(gThis.m_oOptions.sCookieName);
		if ((sCookie == undefined) || (sCookie == '')) {
			gThis.m_aList = [];
			for (i = 0; i < gThis.m_aPossibilitiesList.length; i++) {
				if ((gThis.m_aPossibilitiesList[i] != undefined) && gThis.m_aPossibilitiesList[i].bDefault) {
					gThis.m_aList.push(i);
				}
			}
			gThis._SaveList();
		}
		else {
			gThis.m_aList = sCookie.split(',');
		}
		if (gThis.m_jList == undefined) {
			gThis.m_jList = $(gThis).find('ul:first').wrap('<div class="' + gThis.m_oOptions.oClasses.sListClass + '"/>').closest('div');
			gThis.m_jList.GShadow();
			gThis.m_jCustomizationTrigger = $('<span class="' + gThis.m_oOptions.oClasses.sCustomizeClass + '" title="' + GQuickAccess.Language.customize + '"/>');
			gThis.m_jCustomizationTrigger.click(gThis.OnExpandCustomization);
			gThis.m_jList.append(gThis.m_jCustomizationTrigger);
		}
		var jUl = gThis.m_jList.find('ul:first').empty();
		var aList = [];
		for (i = 0; i < gThis.m_aList.length; i++) {
			var oPossibility = gThis.m_aPossibilitiesList[gThis.m_aList[i]];
			if (oPossibility != undefined) {
				aList.push(gThis.m_aList[i]);
				var jA = $('<a rel="' + gThis.m_aList[i] + '"/>');
				GLink(jA, oPossibility.mLink);
				jA.append('<span class="' + gThis.m_oOptions.oClasses.sCaptionClass + '">' + oPossibility.sCaption + '</span>');
				jUl.append($('<li/>').append(jA));
			}
		}
	};
	
	gThis._PreparePossibilitiesList = function() {
		gThis.m_jPossibilitiesList = $('<div class="' + gThis.m_oOptions.oClasses.sPossibilitiesListClass + '"/>');
		var jUl = $('<ul/>');
		for (var i = 0; i < gThis.m_aPossibilitiesList.length; i++) {
			if (($.inArray(i, gThis.m_aList) == -1) && ($.inArray('' + i, gThis.m_aList) == -1)) {
				var oPossibility = gThis.m_aPossibilitiesList[i];
				var jA = $('<a rel="' + i + '"/>');
				GLink(jA, oPossibility.mLink);
				jA.append('<span class="' + gThis.m_oOptions.oClasses.sCaptionClass + '">' + oPossibility.sCaption + '</span>');
				jUl.append($('<li/>').append(jA));
			}
		}
		gThis.m_jPossibilitiesList.append(jUl);
		var jSaveTrigger = $('<a href="#" class="' + gThis.m_oOptions.oClasses.sButtonClass + '" title="' + GQuickAccess.Language.save_desc + '"><span>' + GQuickAccess.Language.save + '</span></a>');
		jSaveTrigger.click(gThis.OnSave);
		var jCancelTrigger = $('<a href="#" title="' + GQuickAccess.Language.restore_default_desc + '"><span>' + GQuickAccess.Language.restore_default + '</span></a>');
		jCancelTrigger.click(gThis.OnCancel);
		gThis.m_jPossibilitiesList.append($('<p class="' + gThis.m_oOptions.oClasses.sSaveClass + '"/>').append(jSaveTrigger));
		gThis.m_jPossibilitiesList.append($('<p class="' + gThis.m_oOptions.oClasses.sCancelClass + '"/>').append(jCancelTrigger));
		gThis.m_jPossibilitiesList.GShadow();
		$(gThis).append(gThis.m_jPossibilitiesList);
	};
	
	gThis.OnExpandList = new GEventHandler(function(eEvent) {
		gThis.m_bExpanded = true;
		gThis.m_jMainOption.addClass(gThis.m_oOptions.oClasses.sActiveClass);
		gThis.m_jList.css('display', 'none').removeClass(gThis.m_oOptions.oClasses.sHiddenClass).css('left', gThis.m_jMainOption.offset().left - gThis.m_jMainOption.parent().offset().left);
		gThis.m_jList.stop(true, true).slideDown(150);
		return false;
	});
	
	gThis.OnRetractList = new GEventHandler(function(eEvent) {
		if (gThis.m_bCustomization) {
			return;
		}
		gThis.m_bExpanded = false;
		gThis.m_jMainOption.removeClass(gThis.m_oOptions.oClasses.sActiveClass);
		gThis.m_jList.stop(true, true).slideUp(50, function() {
			$(this).css('display', 'block').addClass(gThis.m_oOptions.oClasses.sHiddenClass);
		});
	});
	
	gThis.OnExpandCustomization = new GEventHandler(function(eEvent) {
		if (gThis.m_bCustomization) {
			gThis.OnRetractCustomization({});
			return false;
		}
		gThis.m_bCustomization = true;
		$(gThis).addClass(gThis.m_oOptions.oClasses.sCustomizationClass);
		gThis.m_jList.find('ul:first').sortable({
			placeholder: 'placeholder',
			connectWith: '.' + gThis.m_oOptions.oClasses.sPossibilitiesListClass + ' ul',
			update: gThis.OnChange,
			start: gThis.OnDragStart
		});
		gThis.m_jPossibilitiesList.find('ul:first').sortable({
			placeholder: 'placeholder',
			connectWith: '.' + gThis.m_oOptions.oClasses.sListClass + ' ul',
			update: gThis.OnChange,
			start: gThis.OnDragStart
		});
		gThis.m_jList.find('li a').bind('click', GDoNothing);
		gThis.m_jPossibilitiesList.find('li a').bind('click', GDoNothing);
		gThis.m_jPossibilitiesList.css('left', gThis.m_jMainOption.offset().left - gThis.m_jMainOption.parent().offset().left + gThis.m_jList.width() + 1);
		gThis.m_jPossibilitiesList.slideDown(150);
	});
	
	gThis.OnRetractCustomization = new GEventHandler(function(eEvent) {
		if (!gThis.m_bCustomization) {
			return false;
		}
		gThis.m_bCustomization = false;
		gThis.m_jList.find('ul:first').sortable('destroy');
		gThis.m_jPossibilitiesList.find('ul:first').sortable('destroy');
		gThis.m_jPossibilitiesList.slideUp(50);
		$(gThis).removeClass(gThis.m_oOptions.oClasses.sCustomizationClass);
		gThis.m_jList.find('li a').unbind('click', GDoNothing);
		gThis.m_jPossibilitiesList.find('li a').unbind('click', GDoNothing);
	});
	
	gThis.OnChange = new GEventHandler(function(eEvent, oUi) {
		oUi.item.find('.' + gThis.m_oOptions.oClasses.sAccessKeyClass).remove();
		gThis._UpdateMainOption();
		gThis.m_aList = [];
		var jAs = gThis.m_jList.find('li a');
		for (var i = 0; i < jAs.length; i++) {
			gThis.m_aList.push(jAs.eq(i).attr('rel'));
		}
		gThis._RefreshAccessKeys();
	});
	
	gThis.OnSave = new GEventHandler(function(eEvent) {
		gThis._SaveList();
		gThis.OnRetractCustomization({});
		return false;
	});
	
	gThis.OnCancel = new GEventHandler(function(eEvent) {
		GCookie(gThis.m_oOptions.sCookieName, null);
		gThis.OnRetractCustomization({});
		gThis._PrepareList();
		gThis._PreparePossibilitiesList();
		gThis._UpdateMainOption();
		gThis._RefreshAccessKeys();
		return false;
	});
	
	gThis.OnDragStart = new GEventHandler(function(eEvent, oUi) {
		oUi.helper.find('.' + gThis.m_oOptions.oClasses.sAccessKeyClass).remove();
	});
	
	gThis._UpdateMainOption = function() {
		gThis.m_jMainOption.find('a').remove();
		var jA = gThis.m_jList.find('li:first a:first').clone().attr('accesskey', '');
		jA.find('.' + gThis.m_oOptions.oClasses.sAccessKeyClass).remove();
		gThis.m_jMainOption.prepend(jA);
	};
	
	gThis._RefreshAccessKeys = function() {
		gThis.m_jList.find('a').each(function(i) {
			$(this).find('.' + gThis.m_oOptions.oClasses.sAccessKeyClass).remove();
			if (i < 10) {
				$(this).attr('accesskey', i + 1).prepend('<span class="' + gThis.m_oOptions.oClasses.sAccessKeyClass + '" title="' + GQuickAccess.Language.accesskey + ': ' + (i + 1) + '">' + (i + 1) + '</span>');
			}
		});
	};
	
	gThis._Constructor();
	
};

new GPlugin('GQuickAccess', oDefaults, GQuickAccess);