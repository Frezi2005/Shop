$(function() {
    $("#productNumber").bind("keyup keydown", function() {
        if ($(this).val() > $(this).attr("max")) {
            $(this).val($(this).attr("max"));
        } 
    });

    var items = JSON.parse(localStorage.getItem("cart"));

    $("#addToCartBtn").click(function() {
        if(JSON.parse(localStorage.getItem("cart")) == null) localStorage.setItem("cart", JSON.stringify([]));
        var item = {
            id: $("#productId").val(),
            name: $("#productName").val(),
            price: $("#productPrice").val()
        };
        for (var i = 0; i < items.length; i++) {
            if(!items[i].id.includes(items[i].id)) items.push(item);
        }
        localStorage.setItem("cart", JSON.stringify(items));
    });

    $("#viewCart").click(function() {
        var text = "";
        var cart = JSON.parse(localStorage.getItem("cart"));
        cart.forEach(function(item) {
            // console.log(item);
        });
        // Swal.fire({
        //     icon: "success",
        //     text: "Your account has been verified! You can login now.",
        //     showConfirmButton: true,
        // });
    });
    
});