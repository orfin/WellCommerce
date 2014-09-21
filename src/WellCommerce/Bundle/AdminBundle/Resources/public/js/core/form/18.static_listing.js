/*
* STATIC LISTING
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	sTitle: '',
	bCollapsible: false,
	bExpanded: true,
	oClasses: {
		sFieldClass: 'field-static-listing'
	}
};

var GFormStaticListing = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_jListing;
	gThis.m_jCollapseTrigger;
	gThis.m_bExpanded;
	gThis.m_bShown = false;
	
	gThis._PrepareNode = function() {
		gThis.m_bExpanded = gThis.m_oOptions.bExpanded;
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		if ((gThis.m_oOptions.sLabel != undefined) && gThis.m_oOptions.sLabel.length) {
			gThis.m_jNode.append('<label>' + gThis.m_oOptions.sLabel + '</label>');
		}
		gThis.m_jListing = $('<span class="repetition"/>');
		gThis.m_jNode.append(gThis.m_jListing.empty().append(gThis._MakeListing(gThis.m_oOptions.sTitle, gThis.m_oOptions.aoValues)));
	};
	
	gThis._MakeListing = function(sTitle, aoValues) {
		var jListing = $('<div/>');
		jListing.append('<h3>' + sTitle + '</h3>');
		if (gThis.m_oOptions.bCollapsible) {
			if (gThis.m_bExpanded) {
				gThis.m_jCollapseTrigger = $('<a class="trigger" href="#">' + GForm.Language.static_listing_collapse + '</a>');
			}
			else {
				gThis.m_jCollapseTrigger = $('<a class="trigger" href="#">' + GForm.Language.static_listing_expand + '</a>');
			}
			jListing.append(gThis.m_jCollapseTrigger);
		}
		var jDl = $('<dl/>');
		if (!gThis.m_bExpanded) {
			jDl.css('display', 'none');
		}
		var iLength = aoValues.length;
		for (var i = 0; i < iLength; i++) {
			jDl.append('<dt>' + aoValues[i].sCaption + '</dt>');
			jDl.append('<dd>' + aoValues[i].sValue + '</dd>');
		}
		jListing.append(jDl);
		return jListing;
	};
	
	gThis.OnShow = function() {
		if (gThis.m_bShown) {
			return;
		}
		gThis.m_bShown = true;
		gThis._InitializeExpansion();
	};
	
	gThis.ChangeItems = function(aoItems, sTitle) {
		if (sTitle == undefined) {
			sTitle = gThis.m_oOptions.sTitle;
		}
		gThis.m_jListing.empty().append(gThis._MakeListing(sTitle, aoItems));
		if (gThis.m_bShown) {
			gThis._InitializeExpansion();
		}
	};
	
	gThis._InitializeExpansion = function() {
		if (gThis.m_jCollapseTrigger != undefined) {
			gThis.m_jCollapseTrigger.click(GEventHandler(function(eEvent) {
				gThis.m_bExpanded = !gThis.m_bExpanded;
				if (gThis.m_bExpanded) {
					gThis.m_jListing.find('dl').slideDown(300);
					gThis.m_jCollapseTrigger.text(GForm.Language.static_listing_collapse);
				}
				else {
					gThis.m_jListing.find('dl').slideUp(300);
					gThis.m_jCollapseTrigger.text(GForm.Language.static_listing_expand);
				}
				return false;
			}));
		}
	};
	
	gThis.Focus = function() { return false; };
	
}, oDefaults);