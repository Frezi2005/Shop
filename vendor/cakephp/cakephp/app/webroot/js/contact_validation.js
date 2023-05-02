$(() => {
    $("form").submit((e) => {
        var text = '';

        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
            text += lang.recaptcha_error;
        }

        if (
			$("input#contactFormFrom").val().length == 0 ||
			!/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($("input#contactFormFrom").val())
		) {
            e.preventDefault();
            text += lang.email_error;
        }

        if ($("textarea#contactFormMessage").val().length == 0 || $("textarea#contactFormMessage").val().length > 250) {
            e.preventDefault();
            text += lang.message_error;
        }

        if (text) {
            Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: text
			});
        }
    });
});
