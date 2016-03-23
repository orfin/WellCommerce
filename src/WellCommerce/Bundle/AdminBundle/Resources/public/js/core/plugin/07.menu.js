/*
* MENU
*/

var GMENU_MODE_CLICK = 0;
var GMENU_MODE_DELAY = 1;
var GMENU_MODE_HOVER = 2;

var GMENU_FOLLOW = 1;
var GMENU_NOFOLLOW = 0;

var oDefaults = {
	oClasses: {
		sCustomizationClass: 'customization',
		sCustomizeClass: 'customize',
		sExpandableClass: 'expandable',
		sButtonClass: 'button',
		sCancelClass: 'cancel',
		sSaveClass: 'save',
		sActiveClass: 'active'
	},
	iDefaultMode: GMENU_MODE_HOVER,
	iDefaultDelay: 500,
	iDefaultFollow: GMENU_NOFOLLOW,
	sModeCookieName: 'gekosale-panel-menu-mode',
	sDelayCookieName: 'gekosale-panel-menu-delay',
	sFollowCookieName: 'gekosale-panel-menu-follow',
};

var GMenu = function() {
	
	var gThis = this;
	
	gThis.m_jCustomizationTrigger;
	gThis.m_jCustomization;
	
	gThis.m_iMode;
	gThis.m_iDelay;
	gThis.m_bCustomization;
	
	gThis._Constructor = function() {
		gThis.m_bCustomization = false;
		gThis._UpdateParams();
		$(gThis).find('li:has(ul)').mouseenter(gThis.OnMouseEnter).mouseleave(gThis.OnMouseLeave).children('ul').hide();
		$(gThis).find('li:has(ul)').children('a').click(gThis.OnMouseClick);
		$(gThis).find('li li:has(ul)').addClass(gThis.m_oOptions.oClasses.sExpandableClass);
		gThis._PrepareCustomization();
	};
	
	gThis._PrepareCustomization = function() {
		gThis.m_jCustomizationTrigger = $('<span class="' + gThis.m_oOptions.oClasses.sCustomizeClass + '" title="' + GMenu.Language.customize + '"/>');
		gThis.m_jCustomizationTrigger.click(gThis.OnExpandCustomization);
		gThis.m_jCustomization = $('<div class="' + gThis.m_oOptions.oClasses.sCustomizationClass + '"/>');
		gThis.m_jCustomization.append('<h3>' + GMenu.Language.choose_mode + '</h3>');
		gThis.m_jCustomization.append('<label><input type="radio" name="GMenu-' + gThis.m_iId + '-mode" value="' + GMENU_MODE_CLICK + '"/> ' + GMenu.Language.mode_click + '</label>');
		gThis.m_jCustomization.append('<label><input type="radio" name="GMenu-' + gThis.m_iId + '-mode" value="' + GMENU_MODE_HOVER + '"/> ' + GMenu.Language.mode_hover + '</label>');
		var jSaveTrigger = $('<a href="#" class="' + gThis.m_oOptions.oClasses.sButtonClass + '" title="' + GMenu.Language.save_desc + '"><span>' + GMenu.Language.save + '</span></a>');
		jSaveTrigger.click(gThis.OnSave);
		var jCancelTrigger = $('<a href="#" title="' + GMenu.Language.restore_default_desc + '"><span>' + GMenu.Language.restore_default + '</span></a>');
		jCancelTrigger.click(gThis.OnCancel);
		gThis.m_jCustomization.append($('<p class="' + gThis.m_oOptions.oClasses.sSaveClass + '"/>').append(jSaveTrigger));
		gThis.m_jCustomization.append($('<p class="' + gThis.m_oOptions.oClasses.sCancelClass + '"/>').append(jCancelTrigger));
		gThis.m_jCustomization.hide();
		$(gThis).after(gThis.m_jCustomization);
		$(gThis).after(gThis.m_jCustomizationTrigger);
	};
	
	gThis.OnMouseClick = new GEventHandler(function(eEvent) {
		if ((gThis.m_iMode == GMENU_MODE_DELAY) || (gThis.m_iMode == GMENU_MODE_CLICK)) {
			var jLi = $(this).closest('li');
			jLi.stop(true, false);
			gThis._ShowMenu(jLi);
		}
		return false;
	});
	
	gThis.OnMouseEnter = new GEventHandler(function(eEvent) {
		if (gThis.m_iMode == GMENU_MODE_HOVER) {
			gThis._ShowMenu($(this));
		}
		else if (gThis.m_iMode == GMENU_MODE_DELAY) {
			$(this).delay(gThis.m_iDelay, function() {
				gThis._ShowMenu($(this));
			});
		}
	});
	
	gThis.OnMouseLeave = new GEventHandler(function(eEvent) {
		$(this).stop(true, false);
		gThis._HideMenu($(this));
	});
	
	gThis._ShowMenu = function(jParent) {
		if (gThis.m_bCustomization) {
			return;
		}
		var jUl = jParent.find('ul:first');
		jUl.hide().stop(true, true);
		if (jParent.closest('ul').hasClass('GMenu')) {
			jUl.slideDown(150);
		}
		else {
			jUl.show('slide', {}, 150);
		}
	};
	
	gThis._HideMenu = function(jParent) {
		var jUl = jParent.find('ul:first');
		jUl.stop(true, true).fadeOut(50);
	};
	
	gThis._UpdateParams = function() {
		var sCookie;
		var bSave = false;
		sCookie = GCookie(gThis.m_oOptions.sModeCookieName);
		if ((sCookie == undefined) || (sCookie == '')) {
			gThis.m_iMode = parseInt(gThis.m_oOptions.iDefaultMode);
			bSave = true;
		}
		else {
			gThis.m_iMode = parseInt(sCookie);
		}
		sCookie = GCookie(gThis.m_oOptions.sDelayCookieName);
		if ((sCookie == undefined) || (sCookie == '')) {
			gThis.m_iDelay = parseInt(gThis.m_oOptions.iDefaultDelay);
			bSave = true;
		}
		else {
			gThis.m_iDelay = parseInt(sCookie);
		}
		if (bSave) {
			gThis._SaveParams();
		}
	};
	
	gThis._SaveParams = function() {
		GCookie(gThis.m_oOptions.sDelayCookieName, gThis.m_iDelay, {
			expires: GCore.p_oParams.iCookieLifetime
		});
		GCookie(gThis.m_oOptions.sModeCookieName, gThis.m_iMode, {
			expires: GCore.p_oParams.iCookieLifetime
		});
	};
	
	gThis.OnExpandCustomization = new GEventHandler(function(eEvent) {
		if (gThis.m_bCustomization) {
			gThis.OnRetractCustomization({});
			return false;
		}
		gThis.m_jCustomizationTrigger.addClass(gThis.m_oOptions.oClasses.sActiveClass);
		gThis.m_bCustomization = true;
		gThis.m_jCustomization.css('left', - gThis.m_jCustomization.width() + gThis.m_jCustomizationTrigger.offset().left - gThis.m_jCustomizationTrigger.parent().offset().left).slideDown(150);
		gThis.m_jCustomization.find('input[value="' + gThis.m_iMode + '"]').click();
		gThis.m_jCustomization.find('input[name="GMenu-' + gThis.m_iId + '-delay"]').val(gThis.m_iDelay);
	});
	
	gThis.OnRetractCustomization = new GEventHandler(function(eEvent) {
		if (!gThis.m_bCustomization) {
			return false;
		}
		gThis.m_jCustomizationTrigger.removeClass(gThis.m_oOptions.oClasses.sActiveClass);
		gThis.m_bCustomization = false;
		gThis.m_jCustomization.slideUp(100);
	});
	
	gThis.OnSave = new GEventHandler(function(eEvent) {
		gThis.m_iMode = gThis.m_jCustomization.find('input[type="radio"]:checked').val();
		gThis.m_iDelay = parseInt(gThis.m_jCustomization.find('input[name="GMenu-' + gThis.m_iId + '-delay"]').val());
		if (isNaN(gThis.m_iDelay)) {
			gThis.m_iDelay = gThis.m_oOptions.iDefaultDelay;
		}
		gThis._SaveParams();
		gThis.OnRetractCustomization({});
		return false;
	});
	
	gThis.OnCancel = new GEventHandler(function(eEvent) {
		GCookie(gThis.m_oOptions.sDelayCookieName, null);
		GCookie(gThis.m_oOptions.sModeCookieName, null);
		gThis.OnRetractCustomization({});
		gThis._UpdateParams();
		return false;
	});
	
	gThis._Constructor();
	
};

new GPlugin('GMenu', oDefaults, GMenu);