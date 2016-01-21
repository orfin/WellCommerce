/*
* CLIENT ACTIVITY
*/

var oDefaults = {
	oClasses: {
		sButtonClass: 'button'
	},
	jClientId: $(),
	fSource: function() {},
	gProducts: GCore.NULL
};

var GClientActivity = function() {
	
	var gThis = this;
	
	gThis._Constructor = function() {
		gThis.m_oOptions.jClientId.change(GEventHandler(function(eEvent) {
			gThis.LoadActivities();
		}));
		gThis.LoadActivities();
	};
	
	gThis.LoadActivities = function() {
		gThis.m_oOptions.fSource({
			client: gThis.m_oOptions.jClientId.val()
		}, GCallback(gThis.OnActivitiesLoaded));
	};
	
	gThis.OnActivitiesLoaded = function(oData) {
		var aoActivities = oData.clientActivity;
		$(gThis).children('h3').nextAll().remove();
		for (var i = 0; i < aoActivities.length; i++) {
			if ((aoActivities[i].products == undefined) || !(aoActivities[i].products instanceof Array)) {
				aoActivities[i].products = [];
			}
			var jForm = $('<form action="" method="post"/>');
			var iProductsCount = aoActivities[i].products.length;
			jForm.append('<h4>' + aoActivities[i].name + ' <small>(' + iProductsCount + ')</small></h4>');
			var jUl = $('<ul/>');
			for (var j = 0; j < iProductsCount; j++) {
				jUl.append('<li><label><input type="checkbox" name="product[]" value="' + aoActivities[i].products[j].id + '"/> ' + aoActivities[i].products[j].name + '</label></li>');
			}
			jForm.append(jUl);
			jForm.append('<div class="' + gThis._GetClass('Button') + '"><input type="submit" value="' + GClientActivity.Language.add_to_order + '"/></div>');
			$(gThis).append(jForm);
			jForm.submit(GEventHandler(function(eEvent) {
				var jChecked = $(this).find('input:checked');
				var aIds = [];
				for (var i = 0; i < jChecked.length; i++) {
					aIds.push(jChecked.eq(i).attr('value'));
				}
				gThis.m_oOptions.gProducts.AddProducts(aIds);
				return false;
			}));
		}
	};
	
	gThis._Constructor();
	
};

new GPlugin('GClientActivity', oDefaults, GClientActivity);