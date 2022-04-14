$(function() {
    var cart = JSON.parse(localStorage.getItem("cart"));
    var sum = 0;

    for (var i = 0; i < cart.length; i++) {
        sum += parseInt(cart[i].count) * parseFloat(cart[i].price); 
        $(".products").append("<div class='product'><p class='productName' title='" + cart[i].name + "'><i class='fas fa-trash-alt trashIcon' data-product-id='" + cart[i].id + "'></i>" + cart[i].name + "</p><br/><span class='productCount'>" + cart[i].count + "</span><span class='productPrice'>" + cart[i].price + "USD</span></div>");
    }

    if(!sum) {
        history.back();
    }

    $(".products").append("<span>Total: "+(Math.round((sum + Number.EPSILON) * 100) / 100)+"$</span>");

    $(".trashIcon").each(function () {
        $(this).click(function () {
            removeFromCart($(this).data("product-id"));
            var newSum = 0;
            for (var i = 0; i < JSON.parse(localStorage.getItem("cart")).length; i++) {
                newSum += parseInt(JSON.parse(localStorage.getItem("cart"))[i].count) * parseFloat(JSON.parse(localStorage.getItem("cart"))[i].price); 
            }
            $(".products > span").text(Math.round((newSum + Number.EPSILON) * 100) / 100);
            $(this).parent().parent().remove();
            displayItemsInCartGUI(cart);
            displayAmount(cart);
        });
    });
    
    $("button#order").click(function() {
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/order");
    });
});