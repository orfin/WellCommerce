/*
* BLOCK
* Adds rounded corners to a block.
*/

var oDefaults = {
	oClasses: {
		sNE: 'beginning-r',
		sNW: 'beginning-l',
		sSE: 'ending-r',
		sSW: 'ending-l'
	}
};

var GBlock = function() {
	
	var gThis = this;
	
	this._Constructor = function() {
		$(gThis).prepend('<div class="' + gThis.m_oOptions.oClasses.sNE + '"/>');
		$(gThis).prepend('<div class="' + gThis.m_oOptions.oClasses.sNW + '"/>');
		$(gThis).append('<div class="' + gThis.m_oOptions.oClasses.sSE + '"/>');
		$(gThis).append('<div class="' + gThis.m_oOptions.oClasses.sSW + '"/>');
	};
	
	gThis._Constructor();
	
};

new GPlugin('GBlock', oDefaults, GBlock);