$(() => {
    $("#grantAdmin").click(function() {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/grant-admin-privileges?id="+$("select#usersSelect").val()+"&admin=1",
            success: function(result) {
                Swal.fire({
                    title: "Success",
                    text: "Admin privileges granted",
                    icon: "success",
                    button: "OK",
                });
            }
        });
    });

    $("#deleteCustomer").click(function() {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/remove-customer?id="+$("select#customersSelect").val(),
            success: function(result) {
                Swal.fire({
                    title: "Success",
                    text: "Customer account has been removed",
                    icon: "success",
                    button: "OK",
                });
                location.reload();
            }
        });
    });
});