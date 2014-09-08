/*
* SUBMIT
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-submit',
		sButtonClass: 'button'
	},
	sIcon: ''
};

var GFormSubmit = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jNode.append('<button class="' + gThis._GetClass('Button') + '" type="submit" name="' + gThis.GetName() + '"><span>' + gThis.m_oOptions.sLabel + '</span></button>');
		//gThis.m_jNode.append('<span class="' + gThis._GetClass('Button') + '"><span>' + ((gThis.m_oOptions.sIcon != '') ? '<img src="' + GCore.DESIGN_PATH + gThis.m_oOptions.sIcon + '" alt=""/>' : '') + '<input type="submit" name="' + gThis.GetName() + '" value="' + gThis.m_oOptions.sLabel + '"/></span></span>');
	};
	
}, oDefaults);