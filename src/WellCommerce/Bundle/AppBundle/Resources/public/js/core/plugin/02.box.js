/*
* BOX
* Adds a subtle shadow to a block.
*/

var oDefaults = {
	oClasses: {
		sN: 'beginning',
		sS: 'ending'
	}
};

var GBox = function() {
	
	var gThis = this;
	
	gThis._Constructor = function() {
		$(gThis).prepend('<div class="' + gThis.m_oOptions.oClasses.sN + '"/>');
		$(gThis).append('<div class="' + gThis.m_oOptions.oClasses.sS + '"/>');
	};
	
	gThis._Constructor();
	
};

new GPlugin('GBox', oDefaults, GBox);