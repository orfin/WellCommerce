/*
* PASSWORD
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-text',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-field-repetition',
		sRemoveRepetitionClass: 'remove-field-repetition'
	},
	oImages: {
		sAddRepetition: 'images/icons/buttons/add.png',
		sRemoveRepetition: 'images/icons/buttons/delete.png'
	},
	sFieldType: 'password',
	sDefault: '',
	aoRules: []
};

var GFormPassword = GCore.ExtendClass(GFormTextField, function() {
	
	var gThis = this;
	
}, oDefaults);