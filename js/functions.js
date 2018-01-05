$(document).ready(function() {

	// Alerts
	function alertWidget(div, message, type, duration) {
	    $(div).addClass('slide');
	    $(div).html('<div class="alert '+ type +'" style="cursor:pointer;">' + message + '</div>');
	    setTimeout(function(){
	        $(div).removeClass('slide');
	    }, duration);
	}

	$(document).on('click', '#alerts', function() {
		$(this).removeClass("slide");
	});

	// Select change
	$(".input-form").on("change", ".file-upload-field", function(){
		if ($(this).val() == "") {
			$(this).parent(".file-upload-wrapper").attr("data-text", 'Sélectionnez votre fichier' );
		} else {
			$(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, '') );
		}
	});

	// Add or remove error to an input (or to a selection)
	function addError(input, text, selection) {
		if (!input.val()) {
			selection ? $(selection).addClass(text) : input.addClass(text);
		} else {
			selection ? $(selection).removeClass(text) : input.removeClass(text);
		}
	}

	// Check errors of the first form and ajax
	$(document).on('submit', '#form-sendmarks', function(event) {
		event.preventDefault();

		var $form = $(this);

		var $file = $(this).find('input[name=file]');
		var $matiere = $(this).find('input[name=matiere]');
		var $bareme = $(this).find('input[name=bareme]');

		if (!$file.val() || !$matiere.val() || !$bareme.val()) {
			addError($file, 'input-error', '.file-upload-wrapper');
			addError($matiere, 'input-error', null);
			addError($bareme, 'input-error', null);

			alertWidget("#alerts" ,"Merci de remplir la totalité des champs.", "error", 3000);

			return false;
		}

		var formData = new FormData($form[0]);
		
        $.ajax({
        	type: "POST",
	        url: 'sendmarks.php',
	        data: formData,
			async: false,
			cache: false,
			enctype: 'multipart/form-data',
			contentType: false,
			processData: false,
	        success: function(res) {
	            alertWidget("#alerts" ,"L'étape 1 a été <strong>validée</strong> avec succès.", "success", 3000);
	            $('#content-2').html($(res).find('#content-2').find('form'));
	            
	            containerTransition('.container', $form, "#progressbar li");
	        },
	        error: function(res){
	        	console.log('Erreur :' + res);
	            alertWidget("#alerts" ,"Merci de remplir la totalité des champs.", "error", 3000);
	        },
	    });
	});

	// Check errors of the first form and ajax
	$(document).on('submit', '#form-sendmails', function(event) {
		event.preventDefault();

		var $form = $(this);

		var $matiereValue = $(this).find('input[name=matiereValue]');
		var $baremeValue = $(this).find('input[name=baremeValue]');

		if (!$matiereValue.val() || !$baremeValue.val()) {
			alertWidget("#alerts" ,"Le fichier CSV est incorrect. Merci de vérifier.", "error", 3000);

			return false;
		}

		var formData = new FormData($form[0]);
		
        $.ajax({
        	type: "POST",
	        url: 'sendmarks.php',
	        data: formData,
			async: false,
			cache: false,
			enctype: 'multipart/form-data',
			contentType: false,
			processData: false,
	        success: function(res) {
	            alertWidget("#alerts" ,"L'étape 2 a été <strong>validée</strong> avec succès.", "success", 3000);
	            $('#content-3').html($(res).find('#content-3').children());

	            containerTransition('.container', $form, "#progressbar li");
	        },
	        error: function(res){
	        	console.log('Erreur :' + res);
	            alertWidget("#alerts" ,"Le fichier CSV est incorrect. Merci de vérifier.", "error", 3000);
	        },
	    });
	});

	// Step transitions
	function containerTransition(container, form, progressBar) {
		var currentContainer, nextContainer; // 2 containers
		var left, opacity, scale; // Containers properties which we will animate
		var animating; // Flag to prevent quick multi-click glitches

		if(animating) return false;
		animating = true;
		
		currentContainer = form.closest(container);
		nextContainer = form.closest(container).next();
		
		// Activate next step on progressbar using the index of nextContainer
		$(progressBar).eq($(container).index(nextContainer)).addClass("active");
		
		// Show the next container
		nextContainer.show();

		// Hide the current container with style
		currentContainer.animate({opacity: 0}, {
			step: function(now, mx) {
				// As the opacity of currentContainer reduces to 0 - stored in "now"
				// 1. Scale currentContainer down to 80%
				scale = 1 - (1 - now) * 0.2;

				// 2. Bring nextContainer from the right(50%)
				window.matchMedia("(max-width: 550px)").matches ? left = (now * 50)+"%" : left = ((now * 50) + 50)+"%";

				// 3. Increase opacity of nextContainer to 1 as it moves in
				opacity = 1 - now;

				if (window.matchMedia("(max-width: 550px)").matches) {
				  currentContainer.css({
				        'transform': 'scale('+scale+')',
				        'position': 'absolute'
		      		});
				} else {
					currentContainer.css({
				        'transform': 'translateX(-50%) translateY(-50%) scale('+scale+')',
				        'position': 'absolute'
		      		});
				}

				nextContainer.css({'left': left, 'opacity': opacity});
			},
			duration: 800,
			complete: function(){
				currentContainer.hide();
				animating = false;
			}, 
			// This comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	}

});