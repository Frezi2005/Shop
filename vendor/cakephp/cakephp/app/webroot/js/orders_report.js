$(function() {

    $("#generate").click(function() {
        var min = $("#min").val();
        var max = $("#max").val();
        $.getJSON("http://localhost/Shop/vendor/cakephp/cakephp/get-orders?min="+min+"&max="+max, function(data) {
            var file = Object.keys(data[0].Orders).toString().replaceAll(",", ";") + "%0A";
            for(var i = 0; i < data.length; i++) {
                for(var n in data[i].Orders) {
                    file += data[i].Orders[n] + ";";
                }
                file = file.slice(0, -3);
                file += "%0A";
            }

            $("body").append("<a href='data:application/octet-stream,"+file+"'>download</a>")
        });
    });

});