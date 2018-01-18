$(document).ready(function() {
	// Choice animation reveal 1
	$('#dept_1').click(function() {
		var $li = $(this).closest('li');

		$li.find('.desc').toggleClass('reveal');

		if ($('#pos_2').find('.desc').hasClass('reveal')) {
			$('#pos_2').find('.desc').removeClass('reveal');
		}
	});

	// Choice animation reveal 2
	$('#dept_2').click(function() {
		var $li = $(this).closest('li');

		$li.find('.desc').toggleClass('reveal');

		if ($('#pos_1').find('.desc').hasClass('reveal')) {
			$('#pos_1').find('.desc').removeClass('reveal');
		}
	});
});