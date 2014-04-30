/**
 * ChkObj constructor, checks various elements on admin panel and disables
 * conditionaly specific elements
 *
 * @param checks
 *            string Elements to watch
 * @param applies
 *            string Elements to disable
 */
function ChkObj(checks, applies) {
	this.check = checks;
	this.apply = applies;
	this.state = 0;
}

/**
 * checkBoxChecker method of ChkObj
 */
ChkObj.prototype.checkBoxChecker = function() {
	var isChecked = jQuery(this.check).is(':checked');
	var isDisabled = jQuery(this.check).is(':disabled');

	if (!isChecked || isDisabled) {
		jQuery(this.apply).fadeTo("fast", 0.4).attr('disabled', true);
		this.state = 0;
	} else {
		jQuery(this.apply).fadeTo("fast", 1).removeAttr('disabled');
		this.state = 1;
	}
};

/**
 * selectionChecker method of ChkObj
 */
ChkObj.prototype.selectionChecker = function(maper) {
	var currentSelection = jQuery(this.check).val();

	for ( var item in maper) {
		if (currentSelection == maper[item]) {
			jQuery(this.apply).fadeTo("fast", 0.4).attr('disabled', true);
			this.state = 0;
			break;
		} else {
			jQuery(this.apply).fadeTo("fast", 1).removeAttr('disabled');
			this.state = 1;
		}
	}
};

(function($) {

	$(function() {
		// jQuery loaded scripts
		$( document ).tooltip({ items: "[data-tooltip]" });
	});

}(jQuery));