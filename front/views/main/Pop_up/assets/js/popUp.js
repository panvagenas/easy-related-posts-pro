(function($) {
	var metroWidth = $("#metroW").width();

	erpExtruder = $("#erpProContainer").buildMbExtruder({
		positionFixed : true,
		width : metroWidth,
		sensibility : 800,
		position : position, // top, left, right, bottom
		extruderOpacity : 0.5,
		flapDim : metroWidth*0.8,
		textOrientation : "bt", // or "tb" (top-bottom or bottom-top)
		onExtOpen : function() {
		},
		onExtContentLoad : function() {
		},
		onExtClose : function() {
		},
		hidePanelsOnClose : false,
		autoCloseTime : 0, // 0=never
		slideTimer : 300
	});

	var contentAreaHeight = $("#metroW").parent().height();
	var headerHeight = $('header').height();

	$(window)
	.scroll(
		function() {
			var y = $(window).scrollTop();
			// Reduce load
			if(y%2 == 0){
				return;
			}
			var winHeight = $(window).height();

			if (!erpExtruder.hasClass('userSuppressed')
					&& (y + (winHeight / 2) > ((contentAreaHeight + headerHeight) * triggerAfter)
					|| y == $(document).height() - winHeight)) {
				erpExtruder.openMbExtruder(true, true);
			} else if (erpExtruder.hasClass('userSuppressed')){
				erpExtruder.closeMbExtruder(true);
			}
		});
})(jQuery);