/*
* FIELDSET REPEATABLE
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sRepetitionClass: 'GFormRepetition',
		sAddButtonClass: 'add-repetition',
		sDeleteButtonClass: 'delete-repetition'
	},
	oImages: {
		sDelete: 'images/buttons/small-delete.png',
		sAdd: 'images/buttons/small-add.png'
	},
	aoFields: [],
	agFields: [],
	oRepeat: {
		iMin: 1,
		iMax: 1
	}
};

var GFormFieldsetRepeatable = GCore.ExtendClass(GFormFieldset, function() {
	
}, oDefaults);