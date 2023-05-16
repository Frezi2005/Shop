$(function() {
    var form = $("form#registerEmployeeFormRegisterEmployeePageForm");

    //Employee registration validation
    form.submit(function(e) {
        var name = $("input#registerEmployeeFormName").val();
        var surname = $("input#registerEmployeeFormSurname").val();
        var email = $("input#registerEmployeeFormEmail").val();
        var phoneNumber = $("input#registerEmployeeFormPhoneNumber").val();
        var country = $("input#registerEmployeeFormCountry").val();
        var city = $("input#registerEmployeeFormCity").val();
        var street = $("input#registerEmployeeFormStreet").val();
        var id = $("input#registerEmployeeFormIdNumberAndSeries").val();

        if (!text_validation(name, 3, 40)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.name_error
            });
            e.preventDefault();
        }

        if (!text_validation(surname, 2, 50)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.surname_error
            });
            e.preventDefault();
        }

        if (!email_validation(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.email_error
            });
            e.preventDefault();
        }

        if (!phone_number_validation(phoneNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.phone_error
            });
            e.preventDefault();
        }

        if (!date_validation(birthDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.date_error
            });
            e.preventDefault();
        }

        if (!alpha_validation(country)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.country_error
            });
            e.preventDefault();
        }

        if (!alpha_validation(city)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.city_error
            });
            e.preventDefault();
        }

        if (!alpha_validation(street)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.street_error
            });
            e.preventDefault();
        }

        if (!/\d/.test(id)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: lang.id_error
            });
            e.preventDefault();
        }
    });

    function text_validation(text, min, max) {
        var len = text.length;
        if (len > max || len < min) {
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

    function date_validation(date) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(date);
    }

    function alpha_validation(text) {
        return /[a-zA-Z\-]/.test(text);
    }
});
