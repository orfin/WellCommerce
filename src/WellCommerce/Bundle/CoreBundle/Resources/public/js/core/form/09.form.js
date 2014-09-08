/*
* FORM
*/

var oDefaults = {
	sName: '',
	sFormName: '',
	sClass: '',
	oClasses: {
		sBlockClass: 'block',
		sButtonClass: 'button',
		sButtonImageRightClass: 'right',
		sNavigationClass: 'navigation',
		sPreviousClass: 'previous',
		sNextClass: 'next',
		sInputWithImageClass: 'with-image',
		sActionsClass: 'actions',
		sTabbedClass: 'tabbed'
	},
	oImages: {
		sArrowLeftGray: 'images/icons/buttons/arrow-left-gray.png',
		sArrowRightGreen: 'images/icons/buttons/arrow-right-green.png',
		sSave: 'images/icons/buttons/check.png'
	},
	aoFields: [],
	agFields: [],
	oValues: {},
	iTabs: 0
};

var GForm = GCore.ExtendClass(GFormContainer, function() {
	
	var gThis = this;
	
	gThis.m_bDontFocus = false;
	gThis.m_bPopulatedWithDefaults = false;
	gThis.m_bFocused = false;
	gThis.m_ogFields = {};
	gThis.m_oLocks = {};
	gThis.m_iLockId = 0;
	
	gThis._Constructor = function() {
		GForm.s_agForms[gThis.m_oOptions.sFormName] = gThis;
		gThis.m_gForm = gThis;
		gThis.m_gParent = GCore.NULL;
		$(gThis).addClass(gThis.m_oOptions.sClass);
		gThis._ConstructChildren();
		$(gThis).append('<div class="' + gThis._GetClass('Actions') + '"/>');
		$(gThis).append(gThis.Render());
		gThis.MakeTabs();
		gThis.Populate(gThis.m_oOptions.oValues);
		gThis.m_bPopulatedWithDefaults = true;
		gThis.PopulateErrors(gThis.m_oOptions.oErrors);
		gThis.OnInit();
		gThis._InitButtons();
	};
	
	gThis._InitializeEvents = function() {
		$(gThis).submit(gThis.OnSubmit);
	};
	
	gThis.Lock = function(sTitle, sMessage) {
		gThis.m_oLocks[gThis.m_iLockId++] = {
			sTitle: sTitle,
			sMessage: sMessage
		};
		return gThis.m_iLockId - 1;
	};
	
	gThis.Unlock = function(iLockId) {
		delete gThis.m_oLocks[iLockId];
	};
	
	gThis.OnSubmit = function() {
		for (var i in gThis.m_oLocks) {
			GAlert(gThis.m_oLocks[i].sTitle, gThis.m_oLocks[i].sMessage);
			return false;
		}
		var bResult = gThis.Validate(true);
		if (bResult) {
			GCore.StartWaiting();
		}
		else
		{
			$(gThis).find('.invalid').first().find('input, select').focus();
			
			GAlert.DestroyAll();
			
			GAlert(GForm.Language.form_data_invalid,'', {
				bAutoFocus: false
			});
			
			window.setTimeout(GAlert.DestroyAll, 15000);
			
		}
		return bResult;
	};
	
	gThis.Submit = function(sAction) {
		$(gThis).find('.' + gThis._GetClass('Actions')).empty();
		if ((sAction != undefined) && (sAction != '')) {
			$(gThis).find('.' + gThis._GetClass('Actions')).append('<input type="hidden" name="_Action_' + sAction + '" value="1"/>');
		}
		$(gThis).submit();
	};
	
	gThis._InitButtons = function() {
		var jButtons = $('a[href="#' + $(gThis).attr('id') + '"]');
		jButtons.each(function() {
			var jButton = $(this);
			var sRel = jButton.attr('rel').match(/^[^\[]+/)[0];
			var sAction = jButton.attr('rel').match(/\[[^\]]+\]$/);
			if (sAction != null) {
				sAction = sAction[0].substr(1, sAction[0].length - 2);
			}
			else {
				sAction = null;
			}
			switch (sRel) {
				case 'submit':
					jButton.click(function() {
						gThis.Submit(sAction);
						return false;
					});
					break;
				case 'reset':
					jButton.click(function() {
						gThis.Reset();
						return false;
					});
					break;
			}
		});
	};
	
	gThis.Render = function() {
		return gThis.RenderChildren();
	};
	
	gThis.Reset = function() {
		gThis.OnReset();
		gThis.m_bPopulatedWithDefaults = false;
		gThis.m_oOptions.agFields = gThis.m_agFields;
		gThis.Populate(gThis.m_oOptions.oValues);
		gThis.m_bPopulatedWithDefaults = true;
	};
	
	gThis.MakeTabs = function() {
		if ($(gThis).is('.attributeGroupEditor, .statusChange, .editOrder')) {
			gThis.OnShow();
			return;
		}
		var oThisOptions = gThis.m_oOptions;
		$(gThis).GTabs({
			iType: gThis.m_oOptions.iTabs == GForm.TABS_HORIZONTAL
		});
		gThis.m_oOptions = oThisOptions;
	};
	
	gThis.GetField = function(sName) {
		var asName = sName.split('.');
		if (asName.length == 2) {
			if (asName[0] != gThis.m_oOptions.sFormName) {
				return GForm.GetForm(asName[0]).GetField(asName[1]);
			}
			sName = asName[1];
		}
		return gThis.m_ogFields[sName];
	};
	
	gThis._Constructor();
	
}, oDefaults);

GForm.INFINITE = 99999;

GForm.TABS_VERTICAL = 0;
GForm.TABS_HORIZONTAL = 1;
GForm.s_agForms = {};

GForm.GetForm = function(sName) {
	return GForm.s_agForms[sName];
};

new GPlugin('GForm', oDefaults, GForm);