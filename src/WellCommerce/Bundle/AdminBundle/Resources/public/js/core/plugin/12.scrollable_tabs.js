/*
* SCROLLABLE TABS
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sContainerClass: 'container',
		sControlsClass: 'controls',
		sActiveClass: 'active'
	},
	oImages: {
		sLeft: 'images/icons/buttons/arrow-left-gray.png',
		sRight: 'images/icons/buttons/arrow-right-gray.png'
	}
};

var GScrollableTabs = function() {
	
	var gThis = this;
	
	gThis.m_jUl;
	gThis.m_jContainier;
	gThis.m_jControls;
	gThis.m_jNext;
	gThis.m_jPrevious;
	
	gThis.m_iContainerWidth;
	gThis.m_iUlWidth;
	
	gThis.Constructor = function() {
		gThis.m_jUl = $(gThis).find('ul');
		gThis.m_jUl.wrap('<div class="' + gThis._GetClass('Container') + '"/>');
		gThis.m_jContainier = gThis.m_jUl.parent();
		gThis.m_iContainerWidth = gThis.m_jContainier.width();
		gThis._UpdateWidth();
		if (gThis.m_iUlWidth > gThis.m_iContainerWidth) {
			gThis.m_jControls = $('<p class="' + gThis._GetClass('Controls') + '"/>');
			gThis.m_jNext = $('<a href="#"/>').append('<img src="' + gThis._GetImage('Right') + '" alt="' + GScrollableTabs.Language.next + '" title="' + GScrollableTabs.Language.next + '"/>');
			gThis.m_jPrevious = $('<a href="#"/>').append('<img src="' + gThis._GetImage('Left') + '" alt="' + GScrollableTabs.Language.previous + '" title="' + GScrollableTabs.Language.previous + '"/>');
			gThis.m_jControls.append(gThis.m_jPrevious).append(gThis.m_jNext);
			$(gThis).append(gThis.m_jControls);
		}
		gThis._InitializeEvents();
	};
	
	gThis._UpdateWidth = function() {
		gThis.m_jUl.css('width', 19000);
		var jLis = gThis.m_jUl.children('li');
		var iLisLength = jLis.length;
		var iWidth = 0;
		for (var i = 0; i < iLisLength; i++) {
			iWidth += jLis.eq(i).width() + 4;
		}
		gThis.m_jUl.css('width', iWidth);
		gThis.m_iUlWidth = iWidth;
	};
	
	gThis._InitializeEvents = function() {
		if (gThis.m_jNext != undefined) {
			gThis.m_jNext.click(function() {
				gThis.Right();
				return false;
			});
			gThis.m_jPrevious.click(function() {
				gThis.Left();
				return false;
			});
		}
		gThis.m_jUl.find('a').click(function() {
			GCore.StartWaiting();
			gThis.m_jUl.find('li').removeClass(gThis._GetClass('Active'));
			$(this).closest('li').addClass(gThis._GetClass('Active'));
			gThis._UpdateWidth();
			return true;
		});
	};
	
	gThis.Right = function() {
		
		var left = isNaN(parseInt(gThis.m_jUl.css('left'))) ? 0 : parseInt(gThis.m_jUl.css('left'));
		gThis.m_jUl.stop(true, true).animate({
			left: Math.max(- (gThis.m_iUlWidth - gThis.m_iContainerWidth), left - 250)
		}, 150);
	};
	
	gThis.Left = function() {
		gThis.m_jUl.stop(true, true).animate({
			left: Math.min(0, parseInt(gThis.m_jUl.css('left')) + 250)
		}, 150);
	};
	
	gThis.Constructor();
	
};

new GPlugin('GScrollableTabs', oDefaults, GScrollableTabs);