/*
* RICH TEXT EDITOR
*/

var oDefaults = {
	sName: '',
	sLabel: '',
	oClasses: {
		sFieldClass: 'field-rich-text-editor',
		sFieldSpanClass: 'field',
		sPrefixClass: 'prefix',
		sSuffixClass: 'suffix',
		sFocusedClass: 'focus',
		sInvalidClass: 'invalid',
		sRequiredClass: 'required',
		sWaitingClass: 'waiting',
		sFieldRepetitionClass: 'repetition',
		sAddRepetitionClass: 'add-field-repetition',
		sRemoveRepetitionClass: 'remove-field-repetition',
		sLanguage: 'pl'
	},
	oImages: {
		sAddRepetition: 'images/icons/buttons/add.png',
		sRemoveRepetition: 'images/icons/buttons/delete.png'
	},
	iRows: 3,
	iCols: 60,
	sDefault: '',
	aoRules: [],
	sComment: '',
	bAdvanced: false,
	sLanguage: 'pl'
};

var GFormRichTextEditor = GCore.ExtendClass(GFormTextArea, function() {
	
	var gThis = this;
	
	gThis.OnShow = function() {
		if (gThis.m_bShown) {
			return;
		}
		
//		if(!gThis.m_bShown){
//			$('#' + gThis.GetId()).redactor({ 
//				lang: 'en',
//				imageUpload: GCore.sAdminUrl + 'redactor/add',
//				imageGetJson: GCore.sAdminUrl + 'redactor/view/',
//			});
//			gThis.m_bShown = true;
//		}
	};
	
}, oDefaults);