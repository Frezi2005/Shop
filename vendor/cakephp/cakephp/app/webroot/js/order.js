$(function() {
    var cart;
    var isCart = false;
    var isBuyNow = false;
    if(JSON.parse(localStorage.getItem('buyNow')).length == 1) { 
        cart = JSON.parse(localStorage.getItem('buyNow')) 
        isBuyNow = true;
        localStorage.setItem('buyNow', '[]');
    } else { 
        isCart = true;
        cart = JSON.parse(localStorage.getItem('cart'))
    }
    var sum = 0;
    for(var i = 0; i < cart.length; i++) {
        sum += cart[i].count * cart[i].price;
    }
    $('#sum').text('Sum: ' + sum + '$');
    $('input#orderFormCart').val(JSON.stringify(cart));
    $('input#orderFormPrice').val(sum);

    $('input[type=submit]').click(function() {
        if(isCart) {
            localStorage.setItem('buyNow', '[]');
            localStorage.setItem('cart', '[]');
        } else if(isBuyNow) {
            localStorage.setItem('buyNow', '[]');            
        }
    }); 

});