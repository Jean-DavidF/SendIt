$(document).ready(function() {
	// Select change
	$(".input-form").on("change", ".file-upload-field", function(){
		if ($(this).val() == "") {
			$(this).parent(".file-upload-wrapper").attr("data-text", 'Sélectionnez votre fichier' );
		} else {
			$(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, '') );
		}
	});

	$(document).on('click', '.dropdown-open', function(event) {

		$(".dropdown-list").slideUp(200);
		event.stopPropagation();
		event.preventDefault();

		if ($(this).next().css('display') !== 'block') {
			$(this).next().slideToggle(200);
		}
		
	});

	$(document).on('click', '.refer', function(event) {
		$(".dropdown-list").slideUp(200);
		event.stopPropagation();
		event.preventDefault();

		if ($(this).next().css('display') !== 'block') {
			$(this).next().slideToggle(200);
		}
	});

	$(document).click(function(){
	  $(".dropdown-list").slideUp(200);
	});

	$(document).on('click', '.dropdown-list', function(event) {
		event.stopPropagation();
	});
});