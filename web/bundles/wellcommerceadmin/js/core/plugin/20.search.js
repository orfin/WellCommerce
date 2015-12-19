/*
* SEARCH
* Live Search 
*/

var oDefaults = {
	oClasses: {
	},
	sBackground: '#fff',
	fOpacity: .75,
	iZIndex: 1001,
	iDuration: 200,
	sDefaultText: '',
	sPlaceholder: 'live-search-results'
};

var GSearch = function() {
	
	var gThis = this;
	gThis._Constructor = function() {
		gThis.m_oOptions.sViewUrl = GCore.sAdminUrl+'mainside/confirm/';
		gThis.m_jInput = $(this);
		gThis.sLastValue = gThis.m_jInput.val();
		gThis.m_jInput.attr('autocomplete','off');
		gThis.m_jLiveSearch = $('<div>').attr('id',gThis.m_oOptions.sPlaceholder).appendTo(document.body).hide().slideUp(0);
		$(document.body).click(function(event){
			var clicked = $(event.target);
			if(!(clicked.is('#'+gThis.m_oOptions.sPlaceholder) || clicked.parents('#' + gThis.m_oOptions.sPlaceholder).length || clicked.is('input'))){
				gThis.m_jLiveSearch.slideUp(gThis.m_oOptions.iDuration);
			}
		});
		gThis.OnFocus();
		gThis.OnBlur();
		gThis.OnClick();
		
		gThis.m_jInput.typeWatch({callback: function(){
			gThis.OnTypingFinished();
		}});
	};
	
	gThis.RepositionLiveSearch = function() {
		var liveSearchPaddingBorderHoriz = parseInt(gThis.m_jLiveSearch.css('paddingLeft'), 10) + parseInt(gThis.m_jLiveSearch.css('paddingRight'), 10) + parseInt(gThis.m_jLiveSearch.css('borderLeftWidth'), 10) + parseInt(gThis.m_jLiveSearch.css('borderRightWidth'), 10);
		var tmpOffset = gThis.m_jInput.offset();
		var inputDim = {
			left: tmpOffset.left,
			top: tmpOffset.top,
			width: gThis.m_jInput.outerWidth(),
			height: gThis.m_jInput.outerHeight()
		};
		
		inputDim.topPos = inputDim.top + inputDim.height;
		inputDim.totalWidth = inputDim.width - liveSearchPaddingBorderHoriz;

		gThis.m_jLiveSearch.css({
			position:	'absolute',
			left:	inputDim.left+'px',
			top:	inputDim.topPos+'px',
			width:	inputDim.totalWidth+'px'
		});
	};
	
	gThis.ShowLiveSearch = function() {
		gThis.RepositionLiveSearch();	
		$(window).unbind('resize', gThis.RepositionLiveSearch).bind('resize', gThis.RepositionLiveSearch);
		gThis.m_jLiveSearch.slideDown(gThis.m_oOptions.iDuration);
	};
	
	gThis.HideLiveSearch = function() {
		gThis.m_jLiveSearch.slideUp(gThis.m_oOptions.iDuration);
	};
	
	gThis.OnFocus = function() {
		gThis.m_jInput.focus(function() {
			if(gThis.m_jInput.val() == gThis.m_oOptions.sDefaultText) $(this).val("");
		});
		if (gThis.m_jInput.val() != ''){
			if (gThis.m_jLiveSearch.html() == ''){
				gThis.sLastValue = '';
				gThis.m_jInput.keyup();
			}else{
				setTimeout(gThis.ShowLiveSearch(),1);
			}
		}
	};
	
	gThis.OnClick = function() {
		gThis.m_jInput.click(function(){
			if(gThis.m_jLiveSearch.html() != '') {
				setTimeout(gThis.ShowLiveSearch(),1);
			}	
		});
	};
	
	gThis.OnBlur = function() {
		gThis.m_jInput.blur(function() {
			if(gThis.m_jInput.val() == '') $(this).val(gThis.m_oOptions.sDefaultText);
		});
		if(gThis.m_jLiveSearch.html() != ''){
			gThis.ShowLiveSearch();
		}
	};
	
	gThis.OnTypingFinished = function() {
		if(gThis.sLastValue != gThis.m_jInput.val() && gThis.m_jInput.val() != '' && gThis.m_jInput.val() != gThis.m_oOptions.sDefaultText && gThis.m_jInput.val().length > 2){
			gThis.LoadResults();
		}
	};
	
	gThis.LoadResults = function() {
		gThis.sLastValue = gThis.m_jInput.val();
		$.get(gThis.m_oOptions.sViewUrl + Base64.encode(gThis.m_jInput.val()), function (data){
			if (data.length && gThis.sLastValue.length) {
				gThis.m_jLiveSearch.html(data);
				gThis.ShowLiveSearch();
			}else{
				gThis.HideLiveSearch();
			}
		});
	};
	
	gThis._Constructor();
	
};

new GPlugin('GSearch', oDefaults, GSearch);