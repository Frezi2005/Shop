$(() => {
    //Deleting specific customer
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
