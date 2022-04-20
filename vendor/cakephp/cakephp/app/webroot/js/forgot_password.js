$(function() {
    $("#forgotPasswordFormForgotPasswordPageForm").submit(function(e) {
        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
        }
    });
});