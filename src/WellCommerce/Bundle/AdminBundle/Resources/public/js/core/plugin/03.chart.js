/*
* CHART
* Chart
*/

var oDefaults = {
	oDefaultData: {
    	areaOpacity: 0.6,
    	colors: ['#33cccc', '#CC0000', '#FF7400', '#FF0084', '#4096EE', '#B02B2C', '#D15600', '#C3D9FF', '#CDEB8B', '#36393D'],
    	chartArea: {
        	left: 50,
        	top: 50,
        	height: 300,
        	width: 700,
        	backgroundColor: '#fbfbfb',
        },
        backgroundColor: {
            fill: '#fbfbfb',
        	stroke: '#ececec',
            strokeWidth: 3,
        },
    	width: 850, 
    	height: 400,
    	lineWidth: 3,
    	pointSize: 10,
    	vAxis: {
        	gridlines:{
        		color: '#ececec', 
        	}
        },
    	hAxis: {
        	gridlines:{
        		color: '#ececec', 
        	}
        },
        legend: {
        	position: 'top'
        },
	},
	sType: 'area',
	oParams: {},
	fSource: GCore.NULL,
};

var GChart = function() {
	
	var gThis = this;
	
	gThis._Constructor = function() {
		gThis.oOptions = $.extend(true, GCore.Duplicate(gThis.m_oOptions.oDefaultData, true), gThis.m_oOptions.oParams);
		gThis.Update();
		$(window).bind('hashchange', function() {
			gThis.Update();
		});
	};
	
	gThis.Update = function() {
		
		if(location.hash.length){
			var url = gThis.m_oOptions.fSource + ',' + location.hash.substr(1);
		}else{
			var url = gThis.m_oOptions.fSource;
		}
		var jsonData = $.ajax({
        	url: url,
          	dataType:"json",
          	async: false
		}).responseText;
		
		var data = new google.visualization.DataTable(jsonData);
		var sId = $(gThis).attr('id');
		if(gThis.m_oOptions.sType == 'area'){
			gThis.oChart = new google.visualization.AreaChart(document.getElementById(sId));
		}
		if(gThis.m_oOptions.sType == 'pie'){
			gThis.oChart = new google.visualization.PieChart(document.getElementById(sId));
		}
		gThis.oChart.draw(data, gThis.oOptions);
	};
	
	gThis._Constructor();
	
};

new GPlugin('GChart', oDefaults, GChart);