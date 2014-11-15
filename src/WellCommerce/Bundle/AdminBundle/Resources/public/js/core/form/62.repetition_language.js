/*
* REPETITION LANGUAGE
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
	aoLanguages: [],
	aoFields: [],
	agFields: []
};

var GFormRepetitionLanguage = GCore.ExtendClass(GFormContainer, function(options) {
	
	var gThis = this;
	gThis._PrepareNode = function() {
		gThis.m_jNode = $('<div class="' + gThis._GetClass('Repetition') + '"/>');
		var jFlag = $('<a href="#" class="flag-repetition" tabindex="-1"/>');
		$.each(options.aoLanguages,function(l,language){
			if(language.sValue == options.sName){
			    jFlag.append('<img class="locale" data-locale="'+ options.sName +'" src="' + GCore.DESIGN_PATH+"images/languages/"+language.sFlag + '" alt="' + language.sLabel + '" title="' + language.sLabel + '"/>');
			}
		});
		gThis.m_jNode.append(jFlag);
		gThis.m_jNode.append(gThis.RenderChildren());
	};
	
}, oDefaults);