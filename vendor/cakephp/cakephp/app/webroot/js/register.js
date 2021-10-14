$(function() {
    var form = $("form#registerUserFormRegisterPageForm");

    form.submit(function(e) {
        var name = $("input#registerUserFormName").val();
        var surname = $("input#registerUserFormSurname").val();
        var email = $("input#registerUserFormEmail").val();
        var phoneNumber = $("input#registerUserFormPhoneNumber").val();
        var password = $("input#registerUserFormPassword").val();
        var passwordConfirm = $("input#registerUserFormPasswordConfirm").val();
        var birthDate = $("input#registerUserFormBirthDate").val();
    
        if (
            !text_validation(name, 3, 40) ||
            !text_validation(surname, 2, 50) ||
            !email_validation(email) || 
            !phone_number_validation(phoneNumber) || 
            !password_validation(password) ||
            !date_validation(birthDate) ||
            passwordConfirm != password
        ) {
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
        var regex = /\d/g;
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