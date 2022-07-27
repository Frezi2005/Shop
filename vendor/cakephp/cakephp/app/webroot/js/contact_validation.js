$(() => {
    $("form").submit((e) => {
        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
			Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: 'ReCaptcha has not been submitted!'
			});
        }
        $("span#emailError").empty();
        $("span#messageError").empty();

        if ($("input#contactFormFrom").val().length == 0 || !/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($("input#contactFormFrom").val())) {
            e.preventDefault();
            $("span#emailError").text("Your emails is invalid.");
        }

        if ($("textarea#contactFormMessage").val().length == 0 || $("textarea#contactFormMessage").val().length > 250) {
            e.preventDefault();
            $("span#messageError").text("Your message is either too long or too short.");
        }
    });
});
