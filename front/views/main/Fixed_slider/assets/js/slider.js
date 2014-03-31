function ERPSlider(pos, bkgClr, hghttrgr, trnsprnc) {
	this.w = jQuery("#metroW").width();
	this.position = pos; // TODO Get this from settings
	this.bkgColor = bkgClr; // TODO Get this from options
	this.heightPercentageTrigger = hghttrgr; // TODO Get this from options
	this.transparency = trnsprnc; // TODO Get this from options
	this.headerHeight = jQuery('header').height();
}

ERPSlider.prototype.sliderInitializer = function() {
	this.h = jQuery("#metroW").parent().height();
	console.log(this.h); // TODO
	jQuery("#erpProWraper").css({
		"width" : this.w + "px",
		"position" : "fixed",
		"z-index" : 100,
		"display" : "none"
	});
	switch (this.position) {
	case "left":
	case "right":
	case "top":
		jQuery("#erpProWraper").css({
			"top" : "0px"
		});
		this.transBkg(this.transparency, "top-trns");
		break;
	case "bottom":
		jQuery("#erpProWraper").css({
			"bottom" : "0px"
		});
		this.transBkg(this.transparency, "bottom-trns");
		break;
	default:
		break;
	}
	jQuery(".erpRow").css({
		"margin" : "0px 1% 20px 1%"
	});
};

ERPSlider.prototype.transBkg = function(opacity, pos) {
	jQuery("#erpProWraper").append(
			'<div id="trnsprntbkgrnd" style="background-color:' + this.bkgColor
					+ ';" class="' + pos + '"></div>');
	jQuery("#trnsprntbkgrnd").css({
		"opacity" : opacity
	});
};

ERPSlider.prototype.buttons = function() {
	jQuery("#erpProWraper .erp_h2").before(
			"<div id=\"erp_cont_close\" type=\"button\" ></div>");
	jQuery("#erpProWraper .erp_h2").before("<div id=\"erp_cont_open\"  ></div>");

	jQuery("#erpProWraper .erpRow").wrapAll(
			"<div id=\"containerWraper\"></div>");
	jQuery("#erp_cont_close").click(function() {
		jQuery("#containerWraper").slideToggle("fast", function() {
			jQuery("#erp_cont_close").hide(1);
			jQuery("#erp_cont_open").show(1);
		});
	});
	jQuery("#erp_cont_open").click(function() {
		jQuery("#containerWraper").slideToggle("fast", function() {
			jQuery("#erp_cont_open").hide(1);
			jQuery("#erp_cont_close").show(1);
		});
	});
};

ERPSlider.prototype.erpHideAnim = function() {
	switch (this.position) {
	case "left":
	case "right":
	case "top":
		jQuery("#erpProWraper").slideDown("slow");
		break;
	case "bottom"://bottom
		jQuery("#erpProWraper").slideDown("slow");
		break;
	default:
		break;
	}
};

ERPSlider.prototype.erpShowAnim = function() {
	switch (this.position) {
	case "left":
	case "right":
	case "top":
		jQuery("#erpProWraper").slideUp("slow");
		break;
	case "bottom":
		jQuery("#erpProWraper").slideUp("slow");
		break;
	default:
		break;
	}
};

ERPSlider.prototype.erpToggler = function() {
	jQuery("#erpProWraper .erp_h2").css("margin", "0 0 7px 1%");
	jQuery(window)
			.scroll(
					function() {
						var y = jQuery(window).scrollTop();
						var winHeight = jQuery(window).height();

						if (y + (winHeight / 2) > ((slider.h + slider.headerHeight) * slider.heightPercentageTrigger)
								|| y == jQuery(document).height() - winHeight) {
							slider.erpHideAnim();
						} else {
							slider.erpShowAnim();
						}
					});
};

(function($) {
	slider = new ERPSlider(position, backgroundColor, triggerAfter,
			backgroundTransparency);
	slider.sliderInitializer();
	slider.buttons();
	slider.erpToggler();
})(jQuery);