$(function() {
    $("form").submit(function(e) {
        if($("#deliveryFormProducts :selected").length == 0) {
            Swal.fire({
                title: lang.error,
                text: lang.atleast_one_product,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            e.preventDefault();
        } 

        if(+$("#deliveryFormCount").val() == 0) {
            Swal.fire({
                title: lang.error,
                text: lang.amount_error,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            e.preventDefault();
        }
    });
});