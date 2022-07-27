$(function() {
    $("#forgotPasswordFormForgotPasswordPageForm").submit(function(e) {
        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
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
