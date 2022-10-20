$(function() {
    $("#delAccount").click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: lang.are_you_sure,
            text: lang.no_revert,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang.yes_delete
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    lang.deleted,
                    lang.account_deleted,
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
