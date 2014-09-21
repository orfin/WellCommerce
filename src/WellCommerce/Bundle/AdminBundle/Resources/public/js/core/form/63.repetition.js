/*
* REPETITION
*/

var oDefaults = {
	sName: '',
	oClasses: {
		sRepetitionClass: 'GFormRepetition',
		sDeleteButtonClass: 'delete-repetition'
	},
	oImages: {
		sDelete: 'images/buttons/small-delete.png',
		sAdd: 'images/buttons/small-add.png'
	},
	aoFields: [],
	agFields: []
};

var GFormRepetition = GCore.ExtendClass(GFormContainer, function() {
	
	var gThis = this;
	
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div class="' + gThis._GetClass('Repetition') + '"/>');
		var jDelete = $('<a href="#" class="' + gThis._GetClass('DeleteButton') + '"/>');
		jDelete.append('<img src="' + gThis._GetImage('Delete') + '" alt="' + GForm.Language.delete_repetition + '" title="' + GForm.Language.delete_repetition + '"/>');
		gThis.m_jNode.append(jDelete);
		gThis.m_jNode.append(gThis.RenderChildren());
	};
	
}, oDefaults);