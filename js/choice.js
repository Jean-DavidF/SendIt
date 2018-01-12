$(document).ready(function() {
	// Choice animation reveal 1
	$('#pos_1').click(function() {
		$(this).find('.desc').toggleClass('reveal');

		if ($('#pos_2').find('.desc').hasClass('reveal')) {
			$('#pos_2').find('.desc').removeClass('reveal');
		}
	});

	// Choice animation reveal 2
	$('#pos_2').click(function() {
		$(this).find('.desc').toggleClass('reveal');

		if ($('#pos_1').find('.desc').hasClass('reveal')) {
			$('#pos_1').find('.desc').removeClass('reveal');
		}
	});
});