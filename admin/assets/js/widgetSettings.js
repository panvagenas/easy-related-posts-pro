(function($) {

	$(function() {
		/***********************************************************************
		 * Display layout
		 **********************************************************************/

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
		displayLayoutLoader();
		$( document ).ajaxStop(function() {
			displayLayoutLoader();
		});
	});
}(jQuery));

