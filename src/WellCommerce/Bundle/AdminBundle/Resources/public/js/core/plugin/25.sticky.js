/*
* STICKY
*/

var oDefaults = {
};

var GSticky = function() {
	
	var gThis = this;
	
	gThis._Constructor = function() {
		gThis.m_jSticky = $(gThis);
		gThis.sStickyId = gThis.m_jSticky.attr('id');
		sCookie = GCookie(gThis.sStickyId);
		if(sCookie != undefined && sCookie){
			gThis.m_jSticky.hide();
		}
		
		if(GCore.sCurrentController == 'mainside'){
			setTimeout(function() {
				for(var i = 0; i < 2; i++) {
					gThis.m_jSticky.animate({opacity: 0.2}, 250, 'linear').animate({opacity: 1}, 250, 'linear');
				}
			}, 1500);
		}
		
		gThis.m_jSticky.find('.task-completed a').click(function(){
			gThis.m_jSticky.fadeOut('slow');
			GCookie(gThis.sStickyId, true, {
				expires: GCore.p_oParams.iCookieLifetime
			});
		});
	};
	
	gThis._Constructor();
	
};

new GPlugin('GSticky', oDefaults, GSticky);