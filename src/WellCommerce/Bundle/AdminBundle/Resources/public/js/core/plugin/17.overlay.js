/*
* OVERLAY
* Adds a customizable overlay that covers everything except the element that it's invoked for.
*/

var oDefaults = {
	oClasses: {
	},
	iZIndex: 1000,
	fClick: GCore.NULL,
	fOpacity: 0.0
};

var GOverlay = function() {
	
	var gThis = this;
	
	gThis.m_jOverlay;
	
	this._Constructor = function() {
		gThis.m_jOverlay = $('<div class="GOverlay"/>').css({
			display: 'block',
			position: 'absolute',
			left: 0,
			top: 0,
			width: $(document).width(),
			height: $(document).height(),
			zIndex: gThis.m_oOptions.iZIndex,
			opacity: gThis.m_oOptions.fOpacity,
			background: '#000'
		});
		$('body').append(gThis.m_jOverlay);
		$(gThis).css({
			zIndex: gThis.m_oOptions.iZIndex + 1
		});
		gThis.m_jOverlay.click(GEventHandler(function(eEvent) {
			var bResult = false;
			if (gThis.m_oOptions.fClick instanceof Function) {
				bResult = gThis.m_oOptions.fClick.apply(this, [eEvent]);
			}
			if (!bResult) {
				gThis.m_jOverlay.remove();
			}
			return false;
		}));
	};
	
	gThis._Constructor();
	
};

GOverlay.RemoveAll = function() {
	$('.GOverlay').remove();
};

new GPlugin('GOverlay', oDefaults, GOverlay);
