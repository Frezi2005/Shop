$(function() {

    $("#generate").click(function() {
        var priceMin = $("#priceMin").val();
        var priceMax = $("#priceMax").val();
        var dateMin = $("#dateMin").val();
        var dateMax = $("#dateMax").val();
        var payment = $("#paymentMethod").val();
        var currency = $("#currency").val();
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
    });

});
