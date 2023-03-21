$(() => {

    $("button.buyGift").each(function() {
        $(this).click(function() {
            const giftId = $(this).data("gift-id");
            const userId = $('#userId').val();
            $.ajax({
                url: `http://localhost/Shop/vendor/cakephp/cakephp/buy-gift?id=${giftId}&user_id=${userId}`,
                success: function(result) {
                    Swal.fire({
                        icon: 'success',
                        text: lang.gift_bought,
                        showConfirmButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        onClose: () => {
                            location.reload();
                        }
                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        text: lang.gift_error,
                        showConfirmButton: true,
                        timer: 5000,
                        timerProgressBar: true
                    });
                }
            });
        });
    });
});