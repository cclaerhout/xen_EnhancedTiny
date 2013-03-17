var PasteWordDialog = {
	init : function() {
		var el = document.getElementById('tinymce_paste_iframecontainer'), ifr, doc, css, cssHTML = '';

		// Create iframe
		el.innerHTML = '<iframe id="tinymce_paste_iframe" src="javascript:\'\';" frameBorder="0" style="border: 1px solid gray"></iframe>';
		ifr = document.getElementById('tinymce_paste_iframe');
		doc = ifr.contentWindow.document;

		// Write content into iframe
		doc.open();
		doc.write('<html><head>' + cssHTML + '</head><body class="mceContentBody" spellcheck="false"></body></html>');
		doc.close();

		doc.designMode = 'on';

		window.setTimeout(function() {
			ifr.contentWindow.focus();
		}, 10);
	},
	getMce : function()
	{
		mce = {};
		if (typeof tinyMCEPopup !== 'undefined') {
		       mce.ed = tinyMCEPopup.editor;
		       mce.type = 'popup';
		}
		else if(typeof tinyMCE !== 'undefined') {
			mce.ed = XenForo.tinymce.ed;
			mce.type = 'normal';
		}
		return mce;
	},
	insert : function() {
		var t = this, mce = t.getMce(), ed = mce.ed, h = document.getElementById('tinymce_paste_iframe').contentWindow.document.body.innerHTML;

		ed.execCommand('mceInsertClipboardContent', false, {content : h, wordContent : true});
		
		if(mce.type == 'popup')
		{
			tinyMCEPopup.close();
		}
	}
};
	if (typeof tinyMCEPopup !== 'undefined') {
		tinyMCEPopup.onInit.add(PasteWordDialog.init, PasteWordDialog);
	}
