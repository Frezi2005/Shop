$(function() {
    $("#delAccount").click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your account has been deleted.',
                    'success'
                ).then(() => {
                    setTimeout(() => {
                        location.replace('http://localhost/Shop/vendor/cakephp/cakephp/delete-account');
                    }, 100)
                });
            }
        }) 
    });
});
