$(function() {
	var cart;
    var isCart = false;
    var isBuyNow = false;
    if (localStorage.getItem('buyNow').length != 0) {
        cart = JSON.parse(localStorage.getItem('buyNow'))
        isBuyNow = true;
		localStorage.setItem('buyNow', []);
    } else {
        isCart = true;
        cart = JSON.parse(localStorage.getItem('cart'))
    }

    var sum = 0;

    for (var i = 0; i < cart.length; i++) {
        sum += cart[i].count * parseFloat(cart[i].price.toString().replace(/[^\d]*/, ''));
    }

	if (!sum) {
		history.back();
	}

    $('#sum').text(lang.sum + ': ' + (Math.round((sum + Number.EPSILON) * 100) / 100) + ' ' + localStorage.getItem("currency"));
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

	$("#orderFormCurrency").val(localStorage.getItem("currency"));

    $('form').submit(function(e) {
		if (!$('#orderFormRules').is(':checked')) {
			e.preventDefault();
			$('#checkboxError').css('display', 'inline');
		} else {
			$('#checkboxError').css('display', 'none');
		}
		switch($('select#orderFormPaymentMethod').val()) {
			case 'bank_transfer':
				var selected = false;
				$("#imgGrid img").each(function() {
					if ($(this).hasClass('active')) {
						selected = true;
					}
				});
				if (!selected) {
					e.preventDefault();
					Swal.fire({
						title: 'Oops...',
						icon: 'error',
						text: lang.bank_error
					});
				}
				break;
			case 'PayPal':
				var re = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/gmi;
				if (!re.test($("#paypalEmail").val())) {
					e.preventDefault();
					Swal.fire({
						title: 'Oops...',
						icon: 'error',
						text: lang.paypal_error
					});
				}
				break;
			case 'BLIK':
				var re = /\d{6}/gmi;
				if (!re.test($("#blikCode").val())) {
					e.preventDefault();
					Swal.fire({
						title: 'Oops...',
						icon: 'error',
						text: lang.blik_error
					});
				}
				break;
			case 'credit_card':
				var numberRe = /^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/gmi;
				var cvvRe = /\d{3}/gmi;

				if (!numberRe.test($('#cardNumber').val().replace(/\s/gm, '')) || !cvvRe.test($('#cvv').val()) || !/[a-z]{2,}/gmi.test($('#name').val()) || !/[a-z]{3,}/gmi.test($('#surname').val())) {
					e.preventDefault();
					Swal.fire({
						title: 'Oops...',
						icon: 'error',
						text: lang.credit_error
					});
				}
				break;
		}
    });

    changePaymentInfo($('select#orderFormPaymentMethod'));

    $('select#orderFormPaymentMethod').change(function() {
        changePaymentInfo($(this));
    });

	$("select#orderFormDeliveryType").change(function() {
		if ($(this).val() == "parcel_locker") {
			$("#mapModal").css("display", "block");
			$("#mapModal").css("opacity", "1");
			$(document).mouseup(function(e) {
				var container = $("#mapModal");
		
				if (!container.is(e.target) && container.has(e.target).length === 0) {
					container.slideUp(1000);
				}
			});
		} else {
			$("#mapModal").css("display", "none");
			$("#mapModal").css("opacity", "0");
		}
	});

    function changePaymentInfo(select) {
        switch (select.val()) {
            case 'credit_card':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<input type='text' id='cardNumber' placeholder="${lang.card_number}" pattern='^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\\d{3})\\d{11})$'><input type='number' id='cvv' placeholder="CVV"><input type='month' id='expirationDate' placeholder="${lang.expiration_date}"/><input type='text' id='name' placeholder="${lang.name}"><input type='text' id='surname' placeholder="${lang.surname}">`);
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
                $('div#info').html(`<input type='text' id='paypalEmail' placeholder="${lang.paypal_email}">`);
                break;
            case 'BLIK':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<input type='text' id='blikCode' placeholder="${lang.blik_code}" maxlength="6">`);
                break;
            case 'bank_transfer':
                $('div#paymentInfo').css('display', 'block');
                $('div#info').html(`<div id='imgGrid'><img src='app/webroot/img/ing.jpg'/><img src='app/webroot/img/mbank.jpg'/><img src='app/webroot/img/pko.jpg'/><img src='app/webroot/img/santander.jpg'/><img src='app/webroot/img/credit_agricole.jpg'/><img src='app/webroot/img/millenium.jpg'/><img src='app/webroot/img/bnp_paribas.jpg'/><img src='app/webroot/img/deutsche_bank.jpg'/><img src='app/webroot/img/toyota_bank.jpg'/><img src='app/webroot/img/getin_bank.jpg'/><img src='app/webroot/img/alior_bank.jpg'/><img src='app/webroot/img/noble_bank.jpg'/><img src='app/webroot/img/pko_sa.jpg'/><img src='app/webroot/img/bos_bank.jpg'/></div>`);
                break;
            case '':
                $('div#paymentInfo').css('display', 'none');
                break;
        }
    }

	$('#imgGrid > img').click(function () {
		$('#imgGrid > img').removeClass('active');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
	});
});
