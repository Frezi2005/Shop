$(function() {

    $("#generate").click(function() {
        var min = $("#priceMin").val();
        var max = $("#priceMax").val();
        var payment = $("#paymentMethod").val();
        var currency = $("#currency").val();
        $.getJSON(`http://localhost/Shop/vendor/cakephp/cakephp/get-orders?min=${min}&max=${max}&payment=${payment}&currency=${currency}`, function(data) {
            if (data.length) { 
                var file = Object.keys(data[0].Orders).toString().replaceAll(",", ";") + "%0A";
                for (var i = 0; i < data.length; i++) {
                    for (var n in data[i].Orders) {
                        file += data[i].Orders[n] + ";";
                    }
                    file = file.slice(0, -3);
                    file += "%0A";
                }

                $("body").append("<a href='data:application/octet-stream,"+file+"'>download</a>");
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No orders found',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });

});