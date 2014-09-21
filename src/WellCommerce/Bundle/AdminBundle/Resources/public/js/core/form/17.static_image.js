/*
* STATIC IMAGE
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	sAlt: '',
	sSrc: '',
	oClasses: {
		sFieldClass: 'field-static-image'
	}
};

var GFormStaticImage = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jNode.append('<img id="' + gThis.GetId() + '" src="' + gThis.m_oOptions.sSrc + '" alt="' + gThis.m_oOptions.sAlt + '"/>');
	};
	
	gThis.Focus = function() { return false; };
	
}, oDefaults);