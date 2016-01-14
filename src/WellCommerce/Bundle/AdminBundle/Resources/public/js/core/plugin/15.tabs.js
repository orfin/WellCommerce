/*
* TABS
*/

var oDefaults = {
	oClasses: {
		sBlockClass: 'block',
		sButtonClass: 'button',
		sButtonImageRightClass: 'right',
		sNavigationClass: 'navigation',
		sPreviousClass: 'previous',
		sNextClass: 'next',
		sInputWithImageClass: 'with-image',
		sActionsClass: 'actions',
		sTabbedClass: 'tabbed',
		sTabbedHorizontalClass: 'tabbed-horizontal'
	},
	oImages: {
		sArrowLeftGray: 'images/icons/buttons/arrow-left-gray.png',
		sArrowRightGreen: 'images/icons/buttons/arrow-right-green.png',
		sSave: 'images/icons/buttons/check.png'
	},
	iType: 0
};

var GTabs = function() {
	
	var gThis = this;
	
	this._Constructor = function() {
		gThis._PrepareDOM();
	};
	
	gThis._PrepareDOM = function() {
		var jPanels = $(gThis).children('fieldset');
		if (!jPanels.length) {
			return;
		}
		if (gThis.m_oOptions.iType == GTabs.TABS_HORIZONTAL) {
			$(gThis).addClass(gThis._GetClass('TabbedHorizontal'));
		}
		else {
			$(gThis).addClass(gThis._GetClass('Tabbed'));
		}
		var jTabs = $('<ul class="form-navigation"/>');
		var sLastId = '';
		for (var i = 0; i < jPanels.length; i++) {
			var jPanel = jPanels.eq(i);
			var sId = jPanel.attr('id');
			if (!sId.length) {
				sId = 'GTabs-auto-panel-' + GTabs.s_iId++;
			}
			jPanel.attr('id', '');
			var jWrapper = $('<div/>').attr('id', sId).addClass(gThis._GetClass('Block'));
			jPanel.replaceWith(jWrapper);
			jWrapper.append(jPanel);
			jWrapper.GBlock();
			jTabs.append('<li><a href="#' + sId + '">' + jPanel.find('legend span').eq(0).text() + '</a></li>');
			var jNavigation = $('<ul class="' + gThis._GetClass('Navigation') + '"/>');
			if (i > 0) {
				jNavigation.append('<li class="' + gThis._GetClass('Previous') + '"><a tabindex="-1" class="' + gThis._GetClass('Button') + '" href="#previous-tab"><span><img src="' + gThis._GetImage('ArrowLeftGray') + '" alt=""/>' + GForm.Language.previous + '</span></a></li>');
			}
			if (i < jPanels.length - 1) {
				var sNextId = jPanels.eq(i + 1).attr('id');
				if (!sNextId.length) {
					sNextId = 'GTabs-auto-panel-' + GTabs.s_iId;
				}
				jNavigation.append('<li class="' + gThis._GetClass('Next') + '"><a tabindex="-1" class="' + gThis._GetClass('Button') + ' next" href="#next-tab"><span><img class="' + gThis._GetClass('ButtonImageRight') + '" src="' + gThis._GetImage('ArrowRightGreen') + '" alt=""/>' + GForm.Language.next + '</span></a></li>');
			}
			else if ($(gThis).is('form')) {
				jNavigation.append('<li class="' + gThis._GetClass('Next') + '"><span class="' + gThis._GetClass('Button') + '"><span><img class="' + gThis._GetClass('ButtonImageRight') + '" src="' + gThis._GetImage('Save') + '" alt=""/><input type="submit" class="' + gThis._GetClass('InputWithImage') + '" value="' + GForm.Language.save + '"/></span></span></li>');
			}
			jPanel.append(jNavigation);
			sLastId = sId;
		}
		$(gThis).prepend(jTabs).tabs();
		var jAs = $(gThis).find('.navigation a');
		for (i = 0; i < jAs.length; i++) {
			jAs.eq(i).click(function() {
				$(gThis).tabs('select', $(this).attr('href'));
				return false;
			});
		}
		$(gThis).bind('tabsshow', function(eEvent, oUI) {
			$(oUI.panel).children('fieldset').triggerHandler('GFormShow');
		});
		gThis._SolveAllProblems();
		gThis._InitializeTabsEvents();
	};
	
	gThis._InitializeTabsEvents = function() {
		$('a[href="#previous-tab"]').bind('click', GEventHandler(function(eEvent) {
			var jPanel = $(eEvent.currentTarget).closest('.ui-tabs-panel');
			do {
				jPanel = jPanel.prev();
				if (!jPanel.length) {
					return false;
				}
			} while (jPanel.children('fieldset').css('display') == 'none');
			$(gThis).tabs('select', '#' + jPanel.attr('id'));
			eEvent.stopImmediatePropagation();
			return false;
		}));
		
		$('a[href="#next-tab"]').bind('click', GEventHandler(function(eEvent) {
			var jPanel = $(eEvent.currentTarget).closest('.ui-tabs-panel');
			do {
				jPanel = jPanel.next();
				if (!jPanel.length) {
					return false;
				}
			} while (jPanel.children('fieldset').css('display') == 'none');
			$(gThis).tabs('select', '#' + jPanel.attr('id'));
			eEvent.stopImmediatePropagation();
			return false;
		}));
	};
	
	gThis._SolveAllProblems = function() {
		$(gThis).css({
			opacity: 0,
			height: 0,
			overflow: 'hidden'
		}).tabs('add', '#a', '', 1).tabs('select', 1);
		
				setTimeout(function() {
					$(gThis).tabs('select', 0).tabs('remove', 1).wrap('<div style="clear: both;"/>').css('height', 'auto');
					$(gThis).parent().css('display', 'none').slideDown(350);
					$(gThis).css({
						opacity: 1,
						overflow: 'visible'
					});
				}, 10);
		
//		if(window.location.hash.length){
//			setTimeout(function() {
//				alert(window.location.hash);
//				$('.ui-tabs-nav a[href="'+ window.location.hash +'"]').click();
//			}, 100);
//		}
	};
	
	gThis._Constructor();
	
};

GTabs.TABS_VERTICAL = 0;
GTabs.TABS_HORIZONTAL = 1;

GTabs.s_iId = 0;

new GPlugin('GTabs', oDefaults, GTabs);