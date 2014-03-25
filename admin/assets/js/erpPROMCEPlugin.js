(function() {
	tinymce.create('tinymce.plugins.erpproshortcodehelper', {
		init : function(ed, url) {
			ed.addButton('erpproshortcodehelper', {
				title : 'Easy Related Posts PRO Shortcode Helper',
				image : url+'/erp.png',
				onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					var vidId = prompt("YouTube Video", "Enter the id or url for your video");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[youtube id="'+m[1]+'"]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Easy Related Posts Shortcode Helper",
				author : 'Vagenas Panagiotis',
				authorurl : '', // TODO Configure urls
				infourl : '',
				version : "1.0.0"
			};
		}
	});
	tinymce.PluginManager.add('erpproshortcodehelper', tinymce.plugins.erpproshortcodehelper);
})();