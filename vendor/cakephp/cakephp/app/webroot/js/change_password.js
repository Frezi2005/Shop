$(() => {
    var form = $("#changePasswordFormChangePasswordFormForm");

	//Change password form validation
    form.submit(function(e) {
        var text = '';
        var password = $("#changePasswordFormNewPassword").val();
        var passwordConfirm = $("#changePasswordFormNewPasswordConfirm").val();

        if (password_validation(password)) {
            if (password !== passwordConfirm) {
                text += lang.passwords_match_error;
                e.preventDefault();
            }
        } else {
            text += lang.password_error;
            e.preventDefault();
        }

        if (text != '') {
            Swal.fire({
                title: 'Oops...',
                text: text,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }

    });

    function password_validation(password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/.test(password);
    }
})
