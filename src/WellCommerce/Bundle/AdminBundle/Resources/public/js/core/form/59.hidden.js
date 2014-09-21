/*
* HIDDEN
*/

var oDefaults = {
	sName: '',
	oClasses: {
		sFieldClass: 'field-hidden'
	},
	sFieldType: 'hidden',
	sDefault: '',
	aoRules: [],
	aoDependencies: [],
	sComment: ''
};

var GFormHidden = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jNode.append(gThis._AddField());
	};
	
	gThis.Validate = function(bNoRequests, sRepetition) {
		return true;
	};
	
	gThis._AddField = function(sId) {
		var jField = $('<input type="' + gThis.m_oOptions.sFieldType + '" name="' + gThis.GetName(sId) + '" id="' + gThis.GetId(sId) + '"/>');
		gThis.m_jField = jField;
		return jField;
	};
	
}, oDefaults);