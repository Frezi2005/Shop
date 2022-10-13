$(() => {
    // var submitted = false;

    // $("form").bind("submit", function(e) {
    //     e.preventDefault();
    //     console.log($("#addProductFormImage"));
    //     if($("#addProductFormImage").get(0).files.length === 0) {
    //         e.preventDefault();
    //         Swal.fire({
    //             icon: "error",
    //             html: 'No file selected!',
    //             showConfirmButton: false,
    //             timer: 3000,
    //             timerProgressBar: true
    //         });
    //     }
    //     if (!submitted){
    //         submitted = true;
    //         setTimeout(function() {
    //             $("form").trigger('submit');
    //         }, 3000);
    //         return false;
    //     } else {
    //         return true;
    //     }
    // });

    $("form").submit(function(e) {

        var text = '';

        if($("#addProductFormImage").get(0).files.length === 0) {
            e.preventDefault();
            text += 'No file selected!\n';
        }

        if($("#addProductFormName").val().length == 0 || $("#addProductFormDescription").val().length == 0) {
            e.preventDefault();
            text += 'Name and description must be filled!\n';
        }

        if(text) {
            Swal.fire({
                icon: "error",
                html: text,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

    });

});