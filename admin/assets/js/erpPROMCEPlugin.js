(function($) {
	tinymce.create('tinymce.plugins.erpproshortcodehelper', {
		init : function(ed, url) {
			ed.addButton('erpproshortcodehelper', {
				title : 'Easy Related Posts PRO Shortcode Helper',
				image : url+'/erp.png',
				onclick : function() {
					/*idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					var vidId = prompt("YouTube Video", "Enter the id or url for your video");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[youtube id="'+m[1]+'"]');*/
					var erpModal = {
							init: function () {
								getData = {
									action: 'erpgetShortCodeHelperContent',
									profileName : 'grid'
								};
								$.get(ajaxurl, getData, function(data){
									if(data.error !== undefined){
										alert('There was an error loading shortcode helper.');
										return;
									}
									// create a modal dialog with the data
									$(data).modal({
										closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
										position: ["15%",],
										overlayId: 'erpModal-overlay',
										containerId: 'erpModal-container',
										onOpen: erpModal.open,
										onShow: erpModal.show,
										onClose: erpModal.close
									});
								});
							},
							open: function (dialog) {
								// dynamically determine height
								var h = 280;
								if ($('#erpModal-subject').length) {
									h += 26;
								}
								if ($('#erpModal-cc').length) {
									h += 22;
								}

								var title = $('#erpModal-container .erpModal-title').html();
								$('#erpModal-container .erpModal-title').html('Loading...');
								dialog.overlay.fadeIn(200, function () {
									dialog.container.fadeIn(200, function () {
										dialog.data.fadeIn(200, function () {
											$('#erpModal-container .erpModal-content').animate({
												height: h
											}, function () {
												$('#erpModal-container .erpModal-title').html(title);
												$('#erpModal-container form').fadeIn(200, function () {
													$('#erpModal-container #erpModal-name').focus();
												});
											});
										});
									});
								});
							},
							show: function (dialog) {

							},
							close: function (dialog) {

							},
							error: function (xhr) {
								alert(xhr.statusText);
							},
							validate: function () {

							},
							showError: function () {

							}
						};
					erpModal.init();
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
})(jQuery);