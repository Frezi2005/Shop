$(() => {
    $("#grantAdmin").click(function() {
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/grant-admin-privileges?
				id=${$("select#usersSelect").val()}
				&admin=1`,
            success: function(result) {
                Swal.fire({
                    title: lang.success,
                    text: lang.admin_granted,
                    icon: "success",
                    button: "OK",
                    onClose: () => {
                        location.reload();
                    }
                });
            }
        });
    });

    $("#deleteCustomer").click(function() {
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/remove-customer?id=${$("select#customersSelect").val()}`,
            success: function(result) {
                Swal.fire({
                    title: lang.success,
                    text: lang.customer_removed,
                    icon: "success",
                    button: "OK",
                    onClose: () => {
                        location.reload();
                    }
                });
            }
        });
    });
});
