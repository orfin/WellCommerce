/*
* MESSAGE BAR
*/

var oDefaults = {
	iMessagesToShow: 1,
	oClasses: {
		sMessageClass: 'message',
		sCaptionClass: 'caption',
		sContentClass: 'content',
		sContainerClass: 'layout-container',
		sOptionsClass: 'options',
		sRetractableClass: 'retractable',
		sExpandedClass: 'expanded',
		sTypeWarningClass: 'warning',
		sTypeErrorClass: 'error',
		sTypeMessageClass: 'message',
		sTypePromptClass: 'prompt'
	}
};

var GMessageBar = function() {

	var gThis = this;

	gThis.m_jBox;
	gThis.m_jHoax;
	gThis.m_ojMessages;
	gThis.m_iMargin;

	gThis._Constructor = function() {
		GAlert.sp_dHandler = gThis;
		gThis.m_jBox = $(gThis);
		gThis.m_ojMessages = {};
		gThis.m_jHoax = $('<div/>');
		gThis.m_jHoax.css({
			height: 0
		});
		gThis.m_jBox.before(gThis.m_jHoax);
		gThis.m_jBox.css({
			width: '100%',
			position: 'fixed',
			left: 0,
			top: 0,
			zIndex: 100,
			opacity: 1
		});
		gThis.m_iMargin = gThis.m_jHoax.offset().top;
		$(window).scroll(gThis._UpdateScroll);
		gThis._UpdateScroll();
		gThis._InitExistingMessages();
	};
	
	gThis._UpdateScroll = function(eEvent) {
		if (gThis.m_jHoax.css('display') != 'none') {
			gThis.m_iMargin = gThis.m_jHoax.offset().top;
		}
		if (($(document).scrollTop() < gThis.m_iMargin) || !$(gThis).find('.' + gThis._GetClass('Message')).length) {
			gThis.m_jBox.css({
				position: 'fixed',
				zIndex: 100
			});
			gThis.m_jHoax.css('display', 'none');
		}
		else {
			gThis.m_jBox.css({
				position: 'fixed',
				zIndex: 100
			});
			gThis.m_jHoax.css('display', 'block');
		}
	};
	
	gThis._UpdateHeight = function() {
		gThis.m_jHoax.css('height', gThis.m_jBox.height());
	};

	gThis._InitExistingMessages = function() {
		var jMessages = $(gThis).find('.' + gThis._GetClass('Message'));
		for (var i = 0; i < jMessages.length; i++) {
			var iAlertId = GAlert.Register();
			gThis.m_ojMessages[iAlertId] = jMessages.eq(i);
			gThis._InitMessage(jMessages.eq(i), iAlertId);
			gThis.ShowMessage(jMessages.eq(i));
		}
	};

	gThis._PrepareMessageDOM = function(sTitle, sMessage, oParams) {
		gThis.bAutoFocus = true;
		if (oParams.bAutoFocus == false) {
			gThis.bAutoFocus = false;
		}
		
		if (!oParams.bNoAutoFormatting) {
			sMessage = '<p>' + sMessage + '</p>';
		}
		var jMessage = $('<div class="' + gThis._GetClass('Message') + '"/>');
		var jContainer = $('<div class="' + gThis._GetClass('Container') + '"/>');
		switch (oParams.iType) {
			case GAlert.TYPE_MESSAGE:
				jMessage.addClass(gThis._GetClass('TypeMessage'));
				break;
			case GAlert.TYPE_ERROR:
				jMessage.addClass(gThis._GetClass('TypeError'));
				break;
			case GAlert.TYPE_PROMPT:
				jMessage.addClass(gThis._GetClass('TypePrompt'));
				break;
			default:
				jMessage.addClass(gThis._GetClass('TypeWarning'));
		}
		jContainer.append('<h3>' + sTitle + '</h3>');
		if (!oParams.aoPossibilities || !oParams.aoPossibilities.length) {
			oParams.aoPossibilities = [];
			oParams.aoPossibilities[0] = {
				mLink: GAlert.DestroyThis,
				sCaption: GMessageBar.Language.close_alert
			};
		}
		var jUl = $('<ul class="' + gThis._GetClass('Options') + '"/>');
		for (var i = 0; i < oParams.aoPossibilities.length; i++) {
			var jA = $('<a/>');
			jA.append(oParams.aoPossibilities[i].sCaption);
			GLink(jA, oParams.aoPossibilities[i].mLink);
			if (oParams.aoPossibilities[i].bHidden) {
				jA.css('display', 'none');
			}
			jUl.append($('<li/>').append(jA));
		}
		jContainer.append(jUl);
		jContainer.append('<div class="' + gThis._GetClass('Content') + '">' + sMessage + '</div>');
		jMessage.append(jContainer);
		if (!oParams.bNotRetractable) {
			jMessage.addClass(gThis._GetClass('Retractable'));
			oParams.bAutoExpand = true;
		}
		return jMessage;
	};

	gThis.RetractMessage = function(jMessage) {
		if (!jMessage.hasClass(gThis._GetClass('Retractable'))) {
			return;
		}
		jMessage.get(0).g_bExpanded = false;
		jMessage.removeClass(gThis._GetClass('Expanded'));
		jMessage.stop(true, false).find('.' + gThis._GetClass('Content') + ', .' + gThis._GetClass('Options') + ' li:not(:first-child)').stop(true, false).fadeOut(100, function() {
			jMessage.animate({
				height: jMessage.get(0).g_iRetractedHeight
			}, 150, function() {
				gThis._UpdateHeight();
			});
		});
	};

	gThis._InitMessage = function(jMessage, iAlertId) {
		jMessage.get(0).g_iAlertId = iAlertId;
		jMessage.get(0).g_iExpandedHeight = jMessage.height();
		jMessage.find('.' + gThis._GetClass('Content')).hide();
		jMessage.find('.' + gThis._GetClass('Options') + ' li:not(:first-child)').hide();
		jMessage.get(0).g_iRetractedHeight = jMessage.height();
		jMessage.get(0).g_bExpanded = false;
		jMessage.click(gThis.OnExpandMessage);
		jMessage.find('a').click(new GEventHandler(function(eEvent) {
			eEvent.stopPropagation();
			return true;
		}));
	};

	gThis.OnExpandMessage = new GEventHandler(function(eEvent) {
		if (this.g_bExpanded) {
			gThis.RetractMessage($(this));
		}
		else {
			gThis.ExpandMessage($(this));
		}
		return true;
	});

	gThis.ExpandMessage = function(jMessage) {
		jMessage.get(0).g_bExpanded = true;
		jMessage.addClass(gThis._GetClass('Expanded'));
		jMessage.stop(true, false).animate({
			height: jMessage.get(0).g_iExpandedHeight
		}, 150, function() {
			$(this).find('.' + gThis._GetClass('Content') + ', .' + gThis._GetClass('Options') + ' li:not(:first-child)').stop(true, false).fadeIn(100);
			gThis._UpdateHeight();
			if ($(this).find('input:text').length) {
				$(this).find('input:text:eq(0)').focus().keydown(GEventHandler(function(eEvent) {
					if (eEvent.keyCode == 13) {
						eEvent.preventDefault();
						eEvent.stopImmediatePropagation();
						jMessage.find('.' + gThis._GetClass('Options')).find('a:first').click();
					}
					if (eEvent.keyCode == 27) {
						eEvent.preventDefault();
						eEvent.stopImmediatePropagation();
						jMessage.find('.' + gThis._GetClass('Options')).find('a:last').click();
					}
				}));
			}else{
				if(gThis.bAutoFocus){
					$(this).find('a:first').focus().keydown(GEventHandler(function(eEvent) {
						if (eEvent.keyCode == 13) {
							eEvent.preventDefault();
							eEvent.stopImmediatePropagation();
							jMessage.find('.' + gThis._GetClass('Options')).find('a:first').click();
						}
						if (eEvent.keyCode == 27) {
							eEvent.preventDefault();
							eEvent.stopImmediatePropagation();
							jMessage.find('.' + gThis._GetClass('Options')).find('a:last').click();
						}
					}));
				}
				else{
					$(this).find('a:first').keydown(GEventHandler(function(eEvent) {
						if (eEvent.keyCode == 13) {
							eEvent.preventDefault();
							eEvent.stopImmediatePropagation();
							jMessage.find('.' + gThis._GetClass('Options')).find('a:first').click();
						}
						if (eEvent.keyCode == 27) {
							eEvent.preventDefault();
							eEvent.stopImmediatePropagation();
							jMessage.find('.' + gThis._GetClass('Options')).find('a:last').click();
						}
					}));
				}
				
			}
		});
	};

	gThis.ShowMessage = function(jMessage, bAutoExpand) {
		gThis._UpdateScroll();
		var iTime = 200;
		var nOpacity = .1;
		var jContainer = jMessage.children('.' + gThis._GetClass('Container'));
		jContainer.css('opacity', (document.documentMode == 8) ? '' : 0);
		jMessage.css('height', 0).animate({
			height: jMessage.get(0).g_iRetractedHeight
		}, iTime, function() {
			gThis._UpdateHeight();
			jContainer.animate({
				opacity: (document.documentMode == 8) ? '' : 1
			}, iTime, function() {
				if (bAutoExpand) {
					gThis.ExpandMessage($(this).closest('.' + gThis._GetClass('Message')));
					return;
				}
				gThis.UpdateStack();
				jContainer.animate({
					opacity: (document.documentMode == 8) ? '' : nOpacity
				}, iTime, function() {
					jContainer.animate({
						opacity: (document.documentMode == 8) ? '' : 1
					}, iTime, function() {
						jContainer.animate({
							opacity: (document.documentMode == 8) ? '' : nOpacity
						}, iTime, function() {
							jContainer.animate({
								opacity: (document.documentMode == 8) ? '' : 1
							}, iTime);
						});
					});
				});
			});
		});
	};

	gThis.Destroy = function(mAlert) {
		var iAlertId;
		var jMessage;
		if (!isNaN(mAlert)) {
			iAlertId = mAlert;
			jMessage = gThis.m_ojMessages[iAlertId];
		}
		else {
			if ((mAlert == undefined) || !(mAlert instanceof $)) {
				return;
			}
			jMessage = mAlert.closest('.' + gThis._GetClass('Message'));
			if (!jMessage.length) {
				return;
			}
			iAlertId = jMessage.get(0).g_iAlertId;
		}
		if ((jMessage == undefined) || !(jMessage instanceof $)) {
			return;
		}
		jMessage.stop(true, false).children('.' + gThis._GetClass('Container')).animate({
			opacity: (document.documentMode == 8) ? '' : 0
		}, 100, function() {
			jMessage.animate({
				height: 0
			}, 150, function() {
				jMessage.remove();
				delete gThis.m_ojMessages[iAlertId];
				gThis.UpdateStack();
				gThis._UpdateHeight();
			});
		});
	};
	
	gThis.DestroyAll = function() {
		for (var i in gThis.m_ojMessages) {
			gThis.Destroy(gThis.m_ojMessages[i]);
		}
	};

	gThis.Alert = function(sTitle, sMessage, oParams, iAlertId) {
		oParams = $.extend({}, oParams);
		var jMessage = gThis._PrepareMessageDOM(sTitle, sMessage, oParams);
		gThis.m_jBox.append(jMessage);
		gThis.m_ojMessages[iAlertId] = jMessage;
		gThis._InitMessage(jMessage, iAlertId);
		gThis.ShowMessage(jMessage, (oParams.bAutoExpand == true));
	};
	
	gThis.UpdateStack = function() {
		var jMessages = gThis.m_jBox.find('.' + gThis._GetClass('Message'));
		for (var i = 0; i < jMessages.length; i++) {
			if (jMessages.length - i > gThis.m_oOptions.iMessagesToShow) {
				jMessages.eq(i).css('display', 'none');
			}
			else {
				jMessages.eq(i).css('display', 'block');
			}
		}
	};

	gThis._Constructor();
};

new GPlugin('GMessageBar', oDefaults, GMessageBar);