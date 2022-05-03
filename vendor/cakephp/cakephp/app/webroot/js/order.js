$(function() {
    var cart;
    var isCart = false;
    var isBuyNow = false;
    if (JSON.parse(localStorage.getItem('buyNow')).length == 1) { 
        cart = JSON.parse(localStorage.getItem('buyNow')) 
        isBuyNow = true;
        localStorage.setItem('buyNow', '[]');
    } else { 
        isCart = true;
        cart = JSON.parse(localStorage.getItem('cart'))
    }

    var sum = 0;
    for (var i = 0; i < cart.length; i++) {
        sum += cart[i].count * cart[i].price;
    }

    // if (!sum) {
    //     history.back();
    // }

    $('#sum').text('Sum: ' + (Math.round((sum + Number.EPSILON) * 100) / 100) + '$');
    $('input#orderFormCart').val(JSON.stringify(cart));
    $('input#orderFormPrice').val(sum);

    $('input[type=submit]').click(function() {
        if (isCart) {
            localStorage.setItem('buyNow', '[]');
            localStorage.setItem('cart', '[]');
        } else if (isBuyNow) {
            localStorage.setItem('buyNow', '[]');            
        }
    });

    changePaymentInfo($('select#orderFormPaymentMethod'));
    
    $('select#orderFormPaymentMethod').change(function() {
        changePaymentInfo($(this));
    });

    function changeNoneSelected(select) {
        if (select.val() == 'None') {
            select.css('color', 'grey');
        } else {
            select.css('color', '#000000');
        }
    }

    var selects = $('select');
    selects.each(function() {
        changeNoneSelected($(this));
        $(this).change(function() {
            changeNoneSelected($(this));
        });
    });

    function changePaymentInfo(select) {
        switch (select.val()) {
            case 'Credit card':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<input type='text' id='cardNumber' placeholder="Credit card number" pattern='^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\\d{3})\\d{11})$'><input type='number' id='cvv' placeholder="CVV"><input type='month' id='expirationDate' placeholder="Expiration date"/><input type='text' id='name' placeholder="Name"><input type='text' id='surname' placeholder="Surname">`);
                $('input#expirationDate').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(Date.now()),
                    maxDate: `+4y +${12 - (new Date(Date.now()).getMonth() + 1)}m`,
                    dateFormat: 'MM yy',
                    startView: true,
                    onClose: function(dateText, inst) { 
                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                    }
                  });
                break;
            case 'PayPal':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<input type='text' id='paypalEmail' placeholder="PayPal email">`);
                break;
            case 'BLIK':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<input type='text' id='blikCode' placeholder="BLIK code">`);
                break;
            case 'Bank transfer':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<div id='imgGrid'><img src='app/webroot/img/ing.jpg'/><img src='app/webroot/img/mbank.jpg'/><img src='app/webroot/img/pko.jpg'/><img src='app/webroot/img/santander.jpg'/></div>`);
                break;
            case 'None':
                $('div#paymentInfo').css('display', 'none');
                break;
        }
    }


});