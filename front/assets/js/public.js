(function ( $ ) {
	$.fn.erpDomNext = function() {
        return this
            .next()
            .add(this.next())
            .add(this.parents().filter(function() {
                return $(this).next().length > 0;
            }).next()).first();
    };

    $.fn.erpDomPrevious = function() {
        return this
            .prev().find("*:last")
            .add(this.parent())
            .add(this.prev())
            .last();
    };

	$(function () {

		// Place your public-facing JavaScript here

	});

}(jQuery));