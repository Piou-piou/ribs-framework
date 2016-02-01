$(document).ready(function() {
	function ValidateDate(dtValue)  {
		var dtRegex = new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);
		return dtRegex.test(dtValue);
	}



	//---------------------------- POUR L'EFFET MATERIAL DESIGN LORS D'UN INPUT -----------------------------//
	$('.modifier-contenu .bloc input').focus(function() {
		$parent = $(this).parent();
		$parent.addClass('is-focused has-label');
		$parent.removeClass('invalid');
	});

	$('.modifier-contenu .bloc input').blur(function() {
		$parent = $(this).parent();
		$this = $(this);

        var type = $this.attr("type-val");
        var min = $this.attr("min");
        var max = $this.attr("max");

        if (type == "string") {
            if ($this.val() == "") {
                $parent.addClass('invalid');
                $parent.removeClass('has-label');
            }
            else if (($this.val().length < min) || ($this.val().length > max)) {
                $parent.addClass('invalid');
            }
        }
        else if (type == "date") {
            if (($this.attr('name') == "date") && (!ValidateDate($this.val()))) {
                $parent.addClass('invalid');
            }
        }

		$parent.removeClass('is-focused');
	});

	$('.modifier-contenu .bloc input').each(function() {
		if (($(this).val() != '') || ($(this).val() != 0)) {
			$(this).parent().addClass('has-label');
		}
	});


	$('.modifier-contenu .bloc textarea').focus(function() {
		$parent = $(this).parent();
		$parent.addClass('is-focused has-label');
		$parent.removeClass('invalid');
	});

	$('.modifier-contenu .bloc textarea').blur(function() {
		$parent = $(this).parent();
		$this = $(this);

        var type = $this.attr("type-val");
        var min = $this.attr("min");
        var max = $this.attr("max");

        if (type == "string") {
            if ($this.val() == "") {
                $parent.addClass('invalid');
                $parent.removeClass('has-label');
            }
            else if (($this.val().length < min) || ($this.val().length > max)) {
                $parent.addClass('invalid');
            }
        }

		$parent.removeClass('is-focused');
	});

	$('.modifier-contenu .bloc textarea').each(function() {
		if (($(this).val() != '') || ($(this).val() != 0)) {
			$(this).parent().addClass('has-label');
		}
	});
	//---------------------------- FIN POUR L'EFFET MATERIAL DESIGN LORS D'UN INPUT -----------------------------//



	//---------------------------- POUR L'EFFET LORS DE L'AFFICHAGE LISTE DEROULANTE -----------------------------//
	$("input").focusin(function() {
		if ($(this).attr("liste-deroulante") == "true") {

			$(this).parent().next(".liste-deroulante").addClass("active");
		}
	});

	$("input").focusout(function() {
		if ($(this).attr("liste-deroulante") == "true") {

			$(this).parent().next(".liste-deroulante").removeClass("active");
		}
	});

	$(".liste-deroulante li").click(function() {
		var input = $(this).parent().prev(".bloc").find("input");
		var content_input = input.val();

		if (input.attr("multi") == "true") {
			if (content_input == "") {
				input.val($(this).text());
			}
			else {
				input.val(content_input+", "+$(this).text());
			}
		}
		else {
			input.val($(this).text());
		}

		$(this).parent().prev(".bloc").addClass("has-label");
		$(this).parent().prev(".bloc").removeClass("invalid");
	});
	//---------------------------- FIN POUR L'EFFET LORS DE L'AFFICHAGE LISTE DEROULANTE -----------------------------//
})