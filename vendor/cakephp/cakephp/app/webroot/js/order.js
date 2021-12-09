$(function() {
    var cart = JSON.parse(localStorage.getItem("cart"));
    var sum = 0;
    for(var i = 0; i < cart.length; i++) {
        sum += cart[i].count * cart[i].price;
    }
    $("#sum").text("Sum: " + sum + "$");

    $("button#buy").click(function() {
        $.ajax({
            method: 'get',
            url: 'http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/'
        }); 
    });

});