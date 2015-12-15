/*
* SELECT
* Beautiful select-field replacement.
*/

var oDefaults = {
	oClasses: {
		sFauxClass: 'faux'
	}
};

var GSelect = function() {

	var gThis = this;
	
	this._Constructor = function() {
		var dThis = this;
		
		if (this.bBeautifulized) {
			return;
		}
		this.bBeautifulized = true;

		this.Update = function() {
			$(dThis).parent().find('.faux span').text($(dThis).find('option:selected').text()).attr('class', $(dThis).find('option:selected').attr('class') + ' ');
			return true;
		};
		
		$(this).parent().find('select').css('opacity', 0);
		$(this).parent().append('<span class="faux"><span>' + $(this).find('option:selected').text() + '</span></span>');
		$(this).change(this.Update);
		$(this).focus(function() {
			$(this).closest('.field').addClass('focus');
			return true;
		});
		$(this).blur(function() {
			$(this).closest('.field').removeClass('focus');
			return true;
		});
		this.Update();
	};
	
	gThis._Constructor();
	
};

new GPlugin('GSelect', oDefaults, GSelect);