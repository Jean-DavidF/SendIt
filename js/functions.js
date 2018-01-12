$(document).ready(function() {
	// Select change
	$(".input-form").on("change", ".file-upload-field", function(){
		if ($(this).val() == "") {
			$(this).parent(".file-upload-wrapper").attr("data-text", 'Sélectionnez votre fichier' );
		} else {
			$(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, '') );
		}
	});
});