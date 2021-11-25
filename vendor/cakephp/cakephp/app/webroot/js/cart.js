$(function() {
    var cart = JSON.parse(localStorage.getItem("cart"));
    var sum = 0;

    $(".products").append("<span>Total: "+sum+"$</span>");

    for (var i = 0; i < cart.length; i++) {
        sum += parseInt(cart[i].count) * parseFloat(cart[i].price); 
        $(".products").append("<div class='product'><p class='productName' title='" + cart[i].name + "'><i class='fas fa-trash-alt trashIcon' data-product-id='" + cart[i].id + "'></i>" + cart[i].name + "</p><br/><span class='productCount'>" + cart[i].count + "</span><span class='productPrice'>" + cart[i].price + "USD</span></div>");
    }

    $(".trashIcon").each(function () {
        $(this).click(function () {
            removeFromCart($(this).data("product-id"));
            console.log($(this).parent());
        });
    });

    
});