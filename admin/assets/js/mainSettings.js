

(function($) {

	$(function() {
		/***********************************************************************
		 * Load templates options
		 **********************************************************************/
		$('.dsplLayout')
				.change(
						function() {
							var data = {
								action : 'loadTemplateOptions',
								template : $(this).val(),
								templateRoot : templateRoot
							};
							var that = $(this).parent().children('.templateSettings');
							jQuery
									.post(
											ajaxurl,
											data,
											function(response) {
												if (response == false) {
													alert('Template has no options or template folder couldn\'t be found');
													that.fadeOut('slow', null, function(){$(this).html('');});
												} else {
													that
															.html(
																	response['content']).fadeIn('slow');
												}
											}, 'json');
						});
		$('.dsplLayout').trigger('change');

		/***********************************************************************
		 * Rebuild cache
		 **********************************************************************/
		$('#clearCacheButton')
		.click(
				function() {
					$(this).css('background-image','url(data:image/gif;base64,'+
							'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'
							+'JvjWKcnoGQpqyPlpOhr3aElaqrq56Bq7VAAAOw==)')
							.prop('disabled', true)
							.css('background-color', '#2F4F4F');
					var data = {
						action : 'erpClearCache'
					};
					jQuery
							.post(
									ajaxurl,
									data,
									function(response) {
										if (response == true) {
											alert('Cache cleared.');
										} else {
											alert('There was an error. Action not completed.');
										}
										$('#clearCacheButton').css('background-image', '').prop('disabled', false).css('background-color', '');
									}, 'json');
				});



		/***********************************************************************
		 * Check all checkboxes
		 **********************************************************************/
		$('#select-all-custom').click(function() {
			if (!$(this).is(':checked')) {
				$('.custom').attr('checked', false);
			} else {
				$('.custom').attr('checked', 'checked');
			}
		});

		$('.custom').change(function() {
			if ($('.custom:checked').length === $('.custom').length) {
				$('#select-all-custom').attr('checked', 'checked');
			} else {
				$('#select-all-custom').attr('checked', false);
			}
		});

		$('#select-all-built-in').click(function() {
			if (!$(this).is(':checked')) {
				$('.built-in').attr('checked', false);
			} else {
				$('.built-in').attr('checked', 'checked');
			}
		});

		$('.built-in').change(function() {
			if ($('.built-in:checked').length === $('.built-in').length) {
				$('#select-all-built-in').attr('checked', 'checked');
			} else {
				$('#select-all-built-in').attr('checked', false);
			}
		});

		$('#select-all-tag').click(function() {
			if (!$(this).is(':checked')) {
				$('.tag').attr('checked', false);
			} else {
				$('.tag').attr('checked', 'checked');
			}
		});

		$('.tag').change(function() {
			if ($('.tag:checked').length === $('.tag').length) {
				$('#select-all-tag').attr('checked', 'checked');
			} else {
				$('#select-all-tag').attr('checked', false);
			}
		});

		$('#select-all-cat').click(function() {
			if (!$(this).is(':checked')) {
				$('.cat').attr('checked', false);
			} else {
				$('.cat').attr('checked', 'checked');
			}
		});

		$('.cat').change(function() {
			if ($('.cat:checked').length === $('.cat').length) {
				$('#select-all-cat').attr('checked', 'checked');
			} else {
				$('#select-all-cat').attr('checked', false);
			}
		});

		/***********************************************************************
		 * Tips
		 **********************************************************************/
		tiper('.select-all', 'Select-deselect all');
		tiper('#activate_plugin',
				'If you want to use only the widget</br>of this plugin, uncheck this.');
		tiper('#titletd', 'The text that will appear above the posts');
		tiper('#getPostsBy', 'Fetch posts based on...');
		tiper('#num_of_p_t_dspl', 'How many posts you\'d like to display.');
		tiper(
				'#offset',
				'If you set this as an integer x > 0, then the first x related posts will not be displayed.');
		tiper(
				'#erpcontent',
				'The text that will be displayed for each post.</br>This will go bellow thumbnail if any.');
		tiper(
				'#ttl_sz',
				'Here you can specify the text size of post title.</br>If left zero you themes default h3 will be used.');
		tiper(
				'#exc_sz',
				'Here you can specify the text size of post excerpt.</br>If left zero you themes default paragraph will be used.');
		tiper(
				'#exc_len',
				'How many words post excerpt will span before the read more text.</br>Extremely usefull if you want to cut off large excerpts.');
		tiper(
				'#more_txt',
				'The text that will apear after each post content. Default <em> ...read more</em>');
		tiper(
				'#display_thumbnail',
				'Thumbnail are allways placed before post title.</br>Uncheck if you don\'t want them to appear at all.');
		tiper(
				'#crop_thumbnail',
				'Use this if you want the thumbnail to be croped. \n\
                    Setting the height to some value above zero and the width to zero will result in hard croped thumbnail.</br>\n\
                    Setting both values above zero will result in soft croped, more artistic, thumbnail.');
		tiper(
				'#display_layout',
				'Choose the display layout:</br>\n\
                    <strong>1 post per row:</strong> Just one post per row, something like a list, only seperated by a horizontal rule.</br>\n\
                    <strong>define bellow:</strong> Selecting this will allow you to display as many posts per row you want. Result will be more like a \n\
                        table with no borders.</br>\n\
                    <strong>pop up block:</strong> A block with the posts will slide up or down, when client scrolls down after a point you\'ll have to specify.');
		tiper(
				'#num_of_p_p_row',
				'Specify how many posts per row will be displayed. Width of each post area is depending on your main content width.');
		tiper(
				'#popPos',
				'Choose if you want the posts to slide down from the top, or slide up from the bottom.');
		tiper(
				'#popColor',
				'Set the background color of the pop up block. This should be a hex value. eg #b9a9c6');
		tiper(
				'#popBkg',
				'Set the background transparency of the pop up block. 0 for fully transparent, 1 for solid appearance.');
		tiper(
				'#popTriger',
				'Here you can set the point that pop up block will appear. This is based on post main content height.\n\
                        A value of 0.5 means that if the center of the browser moves bellow the center of the main content area, the pop up will appear.\n\
                        0 to appear from the top of the window, 1 to have to scroll all the way down. If the bottom of content is reached, pop up will appear \n\
                        anyway.');
		tiper(
				'#builtinwarn',
				'These are WP built-in post types. They shouldn\'t be checked unless you are experiencing issues related to a built-in post type.');

		/**
		 * Tab definition
		 */
		options.beforeActivate = function(event, ui) {
			$('#tab-spec').val(ui.newPanel.attr('id').substring(5) - 1);
		};
		$('#tabs-holder').tabs(options);
		/**
		 * -----------------------------------------
		 */

	});

}(jQuery));