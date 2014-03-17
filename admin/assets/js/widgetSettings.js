(function($) {

	$(function() {

		function displayLayoutLoader(){
			$('.dsplLayout').unbind('change')
						.change(
								function() {
									$(this).parent().children(".templateSettings[data-template!='"+$(this).val()+"']").hide().children().prop('disabled', true);
									$(this).parent().children(".templateSettings[data-template='"+$(this).val()+"']").show().children().prop('disabled', false);
								});
			$('.dsplLayout').trigger('change');
		}
		/**
		 * Show templates options
		 */
		/*$('.dsplLayout')
				.change(
						function() {
							$(this).parent().children(".templateSettings[data-template!='"+$(this).val()+"']").hide();
							$(this).parent().children(".templateSettings[data-template='"+$(this).val()+"']").show();
						});
		$('.dsplLayout').trigger('change');*/
		displayLayoutLoader();
	$( document ).ajaxStop(function() {
		displayLayoutLoader();
	});
	});
}(jQuery));

