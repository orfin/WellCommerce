/*
* STATIC TEXT
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-static-text'
	}
};

var GFormStaticText = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jNode.append(gThis.m_oOptions.sText);
	};
	
	gThis.Focus = function() { return false; };
	
}, oDefaults);