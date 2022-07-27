$(function() {
    $("#loginUserFormLoginPageForm").submit(function(e) {
        var email = $("#loginUserFormEmail").val();
        var password = $("#loginUserFormPassword").val();
        if (email.length == 0 || password.length == 0) {
            e.preventDefault();
            Swal.fire({
                title: lang.error,
                text: lang.login_error,
                icon: "error"
            });
        }
    });
});
