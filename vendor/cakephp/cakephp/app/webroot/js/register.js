$(function() {
    var form = $("form#registerUserFormRegisterPageForm");

    $("input#registerUserFormBirthDate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    form.submit(function(e) {
        var name = $("input#registerUserFormName").val();
        var surname = $("input#registerUserFormSurname").val();
        var email = $("input#registerUserFormEmail").val();
        var phoneNumber = $("input#registerUserFormPhoneNumber").val();
        var password = $("input#registerUserFormPassword").val();
        var passwordConfirm = $("input#registerUserFormPasswordConfirm").val();
        var birthDate = $("input#registerUserFormBirthDate").val();
    
        if (!text_validation(name, 3, 40)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Name must be between 3 and 40 characters long!'
            });
            e.preventDefault();
        }

        if (!text_validation(surname, 2, 50)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Surname must be between 2 and 50 characters long!'
            });
            e.preventDefault();
        }

        if (!email_validation(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email is not valid!'
            });
            e.preventDefault();
        }

        if (!phone_number_validation(phoneNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Phone number is not valid!'
            });
            e.preventDefault();
        }

        if (!date_validation(birthDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Birth date is not valid!'
            });
            e.preventDefault();
        }

        if (password_validation(password)) {
            if (password !== passwordConfirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Passwords do not match!'
                });
                e.preventDefault();
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password has to be at least 8 characters long, include only letters and number and at least one uppercase letter!'
            });
            e.preventDefault();
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