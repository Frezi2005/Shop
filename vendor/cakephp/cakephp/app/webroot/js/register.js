$(function() {
    var form = $("form#registerUserFormRegisterPageForm");

    $("input#registerUserFormBirthDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        maxDate: '-16y',
    });
    form.submit(function(e) {
        var name = $("input#registerUserFormName").val();
        var surname = $("input#registerUserFormSurname").val();
        var email = $("input#registerUserFormEmail").val();
        var phoneNumber = $("input#registerUserFormPhoneNumber").val();
        var password = $("input#registerUserFormPassword").val();
        var passwordConfirm = $("input#registerUserFormPasswordConfirm").val();
        var birthDate = $("input#registerUserFormBirthDate").val();

        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
        }

        var text = '';

        if (password_validation(password)) {
            if (password !== passwordConfirm) {
                text += lang.passwords_match_error;
                e.preventDefault();
            }
        } else {
            text += lang.password_error;
            e.preventDefault();
        }

        if (!text_validation(name, 3, 40)) {
            text += lang.name_error;
            e.preventDefault();
        }

        if (!text_validation(surname, 2, 50)) {
            text += lang.surname_error;
            e.preventDefault();
        }

        if (!email_validation(email)) {
            text += lang.email_error;
            e.preventDefault();
        }

        if (!phone_number_validation(phoneNumber)) {
            text += lang.phone_error;
            e.preventDefault();
        }

        if (!date_validation(birthDate)) {
            text += lang.date_error;
            e.preventDefault();
        }

        if(text != '') {
            Swal.fire({
                title: 'Oops...',
                text: text,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });

    function text_validation(name, min, max) {
        var len = name.length;
        if (len == 0 || len > max || len < min) {
            return false;
        }
        return true;
    }

    function email_validation(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function phone_number_validation(phoneNumber) {
        var regex = /^(?:\+\d{1,3}|0\d{1,3}|00\d{1,2})?(?:\s?\(\d+\))?(?:[-\/\s.]|\d)+$/gi;
        return regex.test(phoneNumber);
    }

    function password_validation(password) {
        var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        return regex.test(password);
    }

    function date_validation(date) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(date);
    }
});
