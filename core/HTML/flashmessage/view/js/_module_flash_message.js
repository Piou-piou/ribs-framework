jQuery(function($) {
    var alert = $('.module-flashmessage');
	//test
	if (alert.length > 0) {
		alert.hide().slideDown(500);

		alert.click(function() {
			$(this).slideUp();
		});

		setTimeout("$('.module-flashmessage').slideUp();", 10000);
	}
});