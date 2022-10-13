$(function() {
    $("form").submit(function(e) {
        if($("#deliveryFormProducts :selected").length == 0) {
            Swal.fire({
                title: 'Error',
                text: 'You have to select at least one product!',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            e.preventDefault();
        } 

        if(+$("#deliveryFormCount").val() == 0) {
            Swal.fire({
                title: 'Error',
                text: 'Amount needs to be at least 1!',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            e.preventDefault();
        }
    });
});