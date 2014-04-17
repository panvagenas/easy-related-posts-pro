

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
		 * Clear cache
		 **********************************************************************/
		$('#clearCacheButton')
		.click(
				function() {
					$(this).css('background-image','url(data:image/gif;base64,'+
							'R0lGODlhKAAoAIABAAAAAP///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQABACwAAAAAKAAoAAAC'
							+'kYwNqXrdC52DS06a7MFZI+4FHBCKoDeWKXqymPqGqxvJrXZbMx7Ttc+w9XgU2FB3lOyQRWET2IFG'
							+'iU9m1frDVpxZZc6bfHwv4c1YXP6k1Vdy292Fb6UkuvFtXpvWSzA+HycXJHUXiGYIiMg2R6W459gn'
							+'WGfHNdjIqDWVqemH2ekpObkpOlppWUqZiqr6edqqWQAAIfkECQEAAQAsAAAAACgAKAAAApSMgZnG'
							+'faqcg1E2uuzDmmHUBR8Qil95hiPKqWn3aqtLsS18y7G1SzNeowWBENtQd+T1JktP05nzPTdJZlR6'
							+'vUxNWWjV+vUWhWNkWFwxl9VpZRedYcflIOLafaa28XdsH/ynlcc1uPVDZxQIR0K25+cICCmoqCe5'
							+'mGhZOfeYSUh5yJcJyrkZWWpaR8doJ2o4NYq62lAAACH5BAkBAAEALAAAAAAoACgAAAKVDI4Yy22Z'
							+'nINRNqosw0Bv7i1gyHUkFj7oSaWlu3ovC8GxNso5fluz3qLVhBVeT/Lz7ZTHyxL5dDalQWPVOsQW'
							+'tRnuwXaFTj9jVVh8pma9JjZ4zYSj5ZOyma7uuolffh+IR5aW97cHuBUXKGKXlKjn+DiHWMcYJah4'
							+'N0lYCMlJOXipGRr5qdgoSTrqWSq6WFl2ypoaUAAAIfkECQEAAQAsAAAAACgAKAAAApaEb6HLgd/i'
							+'O7FNWtcFWe+ufODGjRfoiJ2akShbueb0wtI50zm02pbvwfWEMWBQ1zKGlLIhskiEPm9R6vRXxV4Z'
							+'zWT2yHOGpWMyorblKlNp8HmHEb/lCXjcW7bmtXP8Xt229OVWR1fod2eWqNfHuMjXCPkIGNileOiI'
							+'mVmCOEmoSfn3yXlJWmoHGhqp6ilYuWYpmTqKUgAAIfkECQEAAQAsAAAAACgAKAAAApiEH6kb58bi'
							+'Q3FNWtMFWW3eNVcojuFGfqnZqSebuS06w5V80/X02pKe8zFwP6EFWOT1lDFk8rGERh1TTNOocQ61'
							+'Hm4Xm2VexUHpzjymViHrFbiELsefVrn6XKfnt2Q9G/+Xdie499XHd2g4h7ioOGhXGJboGAnXSBno'
							+'BwKYyfioubZJ2Hn0RuRZaflZOil56Zp6iioKSXpUAAAh+QQJAQABACwAAAAAKAAoAAACkoQRqRvn'
							+'xuI7kU1a1UU5bd5tnSeOZXhmn5lWK3qNTWvRdQxP8qvaC+/yaYQzXO7BMvaUEmJRd3TsiMAgswmN'
							+'YrSgZdYrTX6tSHGZO73ezuAw2uxuQ+BbeZfMxsexY35+/Qe4J1inV0g4x3WHuMhIl2jXOKT2Q+VU'
							+'5fgoSUI52VfZyfkJGkha6jmY+aaYdirq+lQAACH5BAkBAAEALAAAAAAoACgAAAKWBIKpYe0L3YNK'
							+'ToqswUlvznigd4wiR4KhZrKt9Upqip61i9E3vMvxRdHlbEFiEXfk9YARYxOZZD6VQ2pUunBmtRXo'
							+'1Lf8hMVVcNl8JafV38aM2/Fu5V16Bn63r6xt97j09+MXSFi4BniGFae3hzbH9+hYBzkpuUh5aZmH'
							+'uanZOZgIuvbGiNeomCnaxxap2upaCZsq+1kAACH5BAkBAAEALAAAAAAoACgAAAKXjI8By5zf4kOx'
							+'TVrXNVlv1X0d8IGZGKLnNpYtm8Lr9cqVeuOSvfOW79D9aDHizNhDJidFZhNydEahOaDH6nomtJjp'
							+'1tutKoNWkvA6JqfRVLHU/QUfau9l2x7G54d1fl995xcIGAdXqMfBNadoYrhH+Mg2KBlpVpbluCiX'
							+'mMnZ2Sh4GBqJ+ckIOqqJ6LmKSllZmsoq6wpQAAAh+QQJAQABACwAAAAAKAAoAAAClYx/oLvoxuJD'
							+'kU1a1YUZbJ59nSd2ZXhWqbRa2/gF8Gu2DY3iqs7yrq+xBYEkYvFSM8aSSObE+ZgRl1BHFZNr7pRC'
							+'avZ5BW2142hY3AN/zWtsmf12p9XxxFl2lpLn1rseztfXZjdIWIf2s5dItwjYKBgo9yg5pHgzJXTE'
							+'eGlZuenpyPmpGQoKOWkYmSpaSnqKileI2FAAACH5BAkBAAEALAAAAAAoACgAAAKVjB+gu+jG4kOR'
							+'TVrVhRlsnn2dJ3ZleFaptFrb+CXmO9OozeL5VfP99HvAWhpiUdcwkpBH3825AwYdU8xTqlLGhtCo'
							+'sArKMpvfa1mMRae9VvWZfeB2XfPkeLmm18lUcBj+p5dnN8jXZ3YIGEhYuOUn45aoCDkp16hl5IjY'
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
		 * Rebuild cache
		 **********************************************************************/
		$('#rebuildCacheButton')
		.click(
				function() {
					$(this).css('background-image','url(data:image/gif;base64,'+
							'R0lGODlhKAAoAIABAAAAAP///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQABACwAAAAAKAAoAAAC'
							+'kYwNqXrdC52DS06a7MFZI+4FHBCKoDeWKXqymPqGqxvJrXZbMx7Ttc+w9XgU2FB3lOyQRWET2IFG'
							+'iU9m1frDVpxZZc6bfHwv4c1YXP6k1Vdy292Fb6UkuvFtXpvWSzA+HycXJHUXiGYIiMg2R6W459gn'
							+'WGfHNdjIqDWVqemH2ekpObkpOlppWUqZiqr6edqqWQAAIfkECQEAAQAsAAAAACgAKAAAApSMgZnG'
							+'faqcg1E2uuzDmmHUBR8Qil95hiPKqWn3aqtLsS18y7G1SzNeowWBENtQd+T1JktP05nzPTdJZlR6'
							+'vUxNWWjV+vUWhWNkWFwxl9VpZRedYcflIOLafaa28XdsH/ynlcc1uPVDZxQIR0K25+cICCmoqCe5'
							+'mGhZOfeYSUh5yJcJyrkZWWpaR8doJ2o4NYq62lAAACH5BAkBAAEALAAAAAAoACgAAAKVDI4Yy22Z'
							+'nINRNqosw0Bv7i1gyHUkFj7oSaWlu3ovC8GxNso5fluz3qLVhBVeT/Lz7ZTHyxL5dDalQWPVOsQW'
							+'tRnuwXaFTj9jVVh8pma9JjZ4zYSj5ZOyma7uuolffh+IR5aW97cHuBUXKGKXlKjn+DiHWMcYJah4'
							+'N0lYCMlJOXipGRr5qdgoSTrqWSq6WFl2ypoaUAAAIfkECQEAAQAsAAAAACgAKAAAApaEb6HLgd/i'
							+'O7FNWtcFWe+ufODGjRfoiJ2akShbueb0wtI50zm02pbvwfWEMWBQ1zKGlLIhskiEPm9R6vRXxV4Z'
							+'zWT2yHOGpWMyorblKlNp8HmHEb/lCXjcW7bmtXP8Xt229OVWR1fod2eWqNfHuMjXCPkIGNileOiI'
							+'mVmCOEmoSfn3yXlJWmoHGhqp6ilYuWYpmTqKUgAAIfkECQEAAQAsAAAAACgAKAAAApiEH6kb58bi'
							+'Q3FNWtMFWW3eNVcojuFGfqnZqSebuS06w5V80/X02pKe8zFwP6EFWOT1lDFk8rGERh1TTNOocQ61'
							+'Hm4Xm2VexUHpzjymViHrFbiELsefVrn6XKfnt2Q9G/+Xdie499XHd2g4h7ioOGhXGJboGAnXSBno'
							+'BwKYyfioubZJ2Hn0RuRZaflZOil56Zp6iioKSXpUAAAh+QQJAQABACwAAAAAKAAoAAACkoQRqRvn'
							+'xuI7kU1a1UU5bd5tnSeOZXhmn5lWK3qNTWvRdQxP8qvaC+/yaYQzXO7BMvaUEmJRd3TsiMAgswmN'
							+'YrSgZdYrTX6tSHGZO73ezuAw2uxuQ+BbeZfMxsexY35+/Qe4J1inV0g4x3WHuMhIl2jXOKT2Q+VU'
							+'5fgoSUI52VfZyfkJGkha6jmY+aaYdirq+lQAACH5BAkBAAEALAAAAAAoACgAAAKWBIKpYe0L3YNK'
							+'ToqswUlvznigd4wiR4KhZrKt9Upqip61i9E3vMvxRdHlbEFiEXfk9YARYxOZZD6VQ2pUunBmtRXo'
							+'1Lf8hMVVcNl8JafV38aM2/Fu5V16Bn63r6xt97j09+MXSFi4BniGFae3hzbH9+hYBzkpuUh5aZmH'
							+'uanZOZgIuvbGiNeomCnaxxap2upaCZsq+1kAACH5BAkBAAEALAAAAAAoACgAAAKXjI8By5zf4kOx'
							+'TVrXNVlv1X0d8IGZGKLnNpYtm8Lr9cqVeuOSvfOW79D9aDHizNhDJidFZhNydEahOaDH6nomtJjp'
							+'1tutKoNWkvA6JqfRVLHU/QUfau9l2x7G54d1fl995xcIGAdXqMfBNadoYrhH+Mg2KBlpVpbluCiX'
							+'mMnZ2Sh4GBqJ+ckIOqqJ6LmKSllZmsoq6wpQAAAh+QQJAQABACwAAAAAKAAoAAAClYx/oLvoxuJD'
							+'kU1a1YUZbJ59nSd2ZXhWqbRa2/gF8Gu2DY3iqs7yrq+xBYEkYvFSM8aSSObE+ZgRl1BHFZNr7pRC'
							+'avZ5BW2142hY3AN/zWtsmf12p9XxxFl2lpLn1rseztfXZjdIWIf2s5dItwjYKBgo9yg5pHgzJXTE'
							+'eGlZuenpyPmpGQoKOWkYmSpaSnqKileI2FAAACH5BAkBAAEALAAAAAAoACgAAAKVjB+gu+jG4kOR'
							+'TVrVhRlsnn2dJ3ZleFaptFrb+CXmO9OozeL5VfP99HvAWhpiUdcwkpBH3825AwYdU8xTqlLGhtCo'
							+'sArKMpvfa1mMRae9VvWZfeB2XfPkeLmm18lUcBj+p5dnN8jXZ3YIGEhYuOUn45aoCDkp16hl5IjY'
							+'JvjWKcnoGQpqyPlpOhr3aElaqrq56Bq7VAAAOw==)')
							.prop('disabled', true)
							.css('background-color', '#2F4F4F');
					var data = {
						action : 'erpRebuildCache'
					};
					jQuery
							.post(
									ajaxurl,
									data,
									function(response) {
										if (response == true) {
											alert('Cache rebuild successfull.');
										} else {
											alert('There was an error. Action not completed.');
										}
										$('#rebuildCacheButton').css('background-image', '').prop('disabled', false).css('background-color', '');
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
		$( ".erpAccordion" ).accordion({ heightStyle: "content", collapsible: true });
	});

}(jQuery));