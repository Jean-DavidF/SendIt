$(document).ready(function() {

	// Alerts
	function alertWidget(div, message, type, duration) {
	    $(div).fadeIn(300);
	    $(div).html('<div class="alert '+ type +'" style="cursor:pointer;" onclick="closeAlert(this)">' + message + '</div>');
	    setTimeout(function(){
	        $(div).fadeOut();
	    }, duration);
	}

	$(document).on('click', '#alerts', function() {
		$(this).fadeOut(300);
	});

	// Select change
	$(".input-form").on("change", ".file-upload-field", function(){
		console.log($(this).val());
		if ($(this).val() == "") {
			$(this).parent(".file-upload-wrapper").attr("data-text", 'Sélectionnez votre fichier' );
		} else {
			$(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, '') );
		}
	});

	function addError(input, text, selection) {
		if (!input.val()) {
			selection ? $(selection).addClass(text) : input.addClass(text);
		} else {
			selection ? $(selection).removeClass(text) : input.removeClass(text);
		}
	}

	$(document).on('submit', '#form-sendmarks', function(event) {

		var $file = $(this).find('input[name=file]');
		var $matiere = $(this).find('input[name=matiere]');
		var $bareme = $(this).find('input[name=bareme]');

		if (!$file.val() || !$matiere.val() || !$bareme.val()) {
			event.preventDefault();

			addError($file, 'input-error', '.file-upload-wrapper');
			addError($matiere, 'input-error', null);
			addError($bareme, 'input-error', null);

			alertWidget("#alerts" ,"Merci de remplir la totalité des champs.", "error", 3000);
		}
	});
});