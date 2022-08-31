$(() => {
    var submitted = false;
    $("form").bind("submit", function() {
        Swal.fire({
            icon: "success",
            html: lang.product_added,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        if (!submitted){
            submitted = true;
            setTimeout(function() {
                $("form").trigger('submit');
            }, 3000);
            return false;
        } else {
            return true;
        }
    });
});