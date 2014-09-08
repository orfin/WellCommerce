/*
* PREVIEW
*/

var oDefaults = {
	sLabel: '',
	sUrl: '',
	iWidth: 400,
	iHeight: 250,
	oClasses: {
		sFieldClass: 'field-preview'
	}
};

var GFormPreview = GCore.ExtendClass(GFormField, function() {
	
	var gThis = this;
	
	gThis.m_jTrigger;
	gThis.m_wWindow;
	
	gThis._PrepareNode = function() {
		if (!gThis.m_oOptions.sLabel.length) {
			gThis.m_oOptions.sLabel = GForm.Language.preview_trigger_label;
		}
		gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
		gThis.m_jTrigger = $('<a href="#">' + gThis.m_oOptions.sLabel + '</a>');
		gThis.m_jNode.append(gThis.m_jTrigger);
	};
	
	gThis._InitializeEvents = function() {
		gThis.m_jTrigger.click(gThis.OnClick);
	};
	
	gThis.OnClick = GEventHandler(function(eEvent) {
		gThis.m_wWindow = window.open('', gThis.GetId(), 'width=' + gThis.m_oOptions.iWidth + 'px, height=' + gThis.m_oOptions.iHeight + 'px, location=false, menubar=false, status=false, toolbar=false');
		gThis.m_wWindow.focus();
		gThis._WriteFormAndSubmitIt();
	});
	
	gThis._WriteFormAndSubmitIt = function() {
		gThis.m_wWindow.document.open();
		gThis.m_wWindow.document.write('<html><head><title>...</title></head><body>');
		gThis.m_wWindow.document.write('<form style="display: none;" id="form" action="' + gThis.m_oOptions.sUrl + '" method="post">');
		gThis.m_wWindow.document.write('</form>');
		gThis.m_wWindow.document.write('</body></html>');
		gThis.m_wWindow.document.close();
		var jFormElements = gThis.m_jNode.closest('.GForm').find('[name]');
		$(gThis.m_wWindow.document.getElementById('form')).append(jFormElements.clone()).submit();
	};
	
	gThis.Focus = function() { return false; };
	
}, oDefaults);