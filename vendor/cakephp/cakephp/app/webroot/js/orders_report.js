$(function() {

    $("#generate").click(function(e) {
        var priceMin = parseFloat($("#priceMin").val());
        var priceMax = parseFloat($("#priceMax").val());
        var dateMin = $("#dateMin").val();
        var dateMax = $("#dateMax").val();
        var payment = $("#paymentMethod").val();
        var currency = $("#currency").val();

        var text = '';

        // if (!price_valiadtion(priceMin)) {
        //     text += lang.price_min_error;
        //     e.preventDefault();
        // }

        // if (!price_valiadtion(priceMax)) {
        //     text += lang.price_max_error;
        //     e.preventDefault();
        // }

        // if (!date_validation(dateMin)) {
        //     text += lang.date_min_error;
        //     e.preventDefault();
        // }

        // if (!date_validation(dateMax)) {
        //     text += lang.date_max_error;
        //     e.preventDefault();
        // }

        if (text != '') {
            Swal.fire({
                title: 'Oops...',
                text: text,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        } else {
            $.getJSON(`http://localhost/Shop/vendor/cakephp/cakephp/get-orders?priceMin=${priceMin}&priceMax=${priceMax}&dateMin=${dateMin}&dateMax=${dateMax}&payment=${payment}&currency=${currency}`, function(data) {
                if (data.length) {
                    var file = Object.keys(data[0].Orders).toString().replaceAll(",", ";") + "%0A";
                    for (var i = 0; i < data.length; i++) {
                        for (var n in data[i].Orders) {
                            file += data[i].Orders[n] + ";";
                        }
                        file = file.slice(0, -3);
                        file += "%0A";
                    }
                    window.open(`data:application/octet-stream,${file}`, '_blank');
                } else {
                    Swal.fire({
                        title: lang.error,
                        text: lang.orders_error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        }
    });

    function price_valiadtion(n) {
        return /^(0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*)$/.test(n);
    }

    function date_validation(date) {
        return /^\d{4}-\d{2}-\d{2}$/.test(date);
    }

});
