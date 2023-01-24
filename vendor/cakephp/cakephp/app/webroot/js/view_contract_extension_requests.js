$(() => {
    $("#table button.accept").click(function() {
        let userId = $(this).parent().siblings().first().text();
        let extendDate = $(this).siblings().last().val();
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/extend-contract?user_id=${userId}&date=${extendDate}`,
            success: function(result) {
                if(result) {
                    location.reload();
                }
            }
        });
    })

    $("#table button.deny").click(function() {
        let userId = $(this).parent().siblings().first().text();
        $.ajax({
            url: `http://localhost/Shop/vendor/cakephp/cakephp/remove-contract-extension-request?user_id=${userId}`,
            success: function(result) {
                if(result) {
                    location.reload();
                }
            } 
        });
    })
})