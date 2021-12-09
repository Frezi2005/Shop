$(function() {
    var form = $("form#registerEmployeeFormRegisterEmployeePageForm");

    form.submit(function(e) {
        var name = $("input#registerEmployeeFormName").val();
        var surname = $("input#registerEmployeeFormSurname").val();
        var email = $("input#registerEmployeeFormEmail").val();
        var phoneNumber = $("input#registerEmployeeFormPhoneNumber").val();
        var country = $("input#registerEmployeeFormCountry").val();
        var city = $("input#registerEmployeeFormCity").val();
        var street = $("input#registerEmployeeFormStreet").val();
        var id = $("input#registerEmployeeFormIdNumberAndSeries").val();
    
        if (!text_validation(name, 3, 40) || !text_validation(surname, 2, 50) || !email_validation(email) ||  
            !phone_number_validation(phoneNumber) || !date_validation(birthDate) || !aplha_validation(country) ||
            !aplha_validation(city) || !aplha_validation(street) || !/\d/.test(id)
        ) {
            e.preventDefault();
        }

    });

    function text_validation(text, min, max) {
        var len = text.length;
        if (len == 0 || len > max || len < min) { //usunac len == 0
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

    function aplha_validation(text) {
        return /[a-zA-Z\-]/.test(text);
    }
});