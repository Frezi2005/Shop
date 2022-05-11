$(() => {

    $("button.buyGift").each(function() {
        $(this).click(function() {
            const giftId = $(this).data("gift-id");
            $.ajax({
                url: `http://localhost/Shop/vendor/cakephp/cakephp/buy-gift?id=${giftId}`,
                success: function(result) {
                    location.reload();
                }
            });
        });
    });
});