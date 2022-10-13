$(function() {
    $("#forgotPasswordFormForgotPasswordPageForm").submit(function(e) {
        if (grecaptcha.getResponse().length == 0) {
			e.preventDefault();
			Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: 'ReCaptcha has not been submitted!'
			});
        }

		if(!$('input#forgotPasswordFormEmail').val()) {
			e.preventDefault();
			Swal.fire({
				title: 'Oops...',
				icon: 'error',
				text: 'Email field cannot be empty!'
			});
		}
    });
});
