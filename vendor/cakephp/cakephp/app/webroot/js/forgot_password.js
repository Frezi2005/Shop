$(function() {
    $("#forgotPasswordFormForgotPasswordPageForm").submit(function(e) {
        if (grecaptcha.getResponse().length == 0) {
			e.preventDefault();
			Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: lang.recaptcha_error
			});
        }

		if(!$('input#forgotPasswordFormEmail').val()) {
			e.preventDefault();
			Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: lang.email_error
			});
		}
    });
});
