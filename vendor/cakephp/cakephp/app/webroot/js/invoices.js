$(() => {

    let params = new URLSearchParams(window.location.search);

    $("select#sort").find("[value='" + params.get("sort_by") + "']").attr("selected", true);
    
    $("#sort").change(function() {
        params.set("sort_by", $(this).val());
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/invoices?" + params.toString());
    });

    $("#filter").click(function () {
        params.set('priceMin', $("input#priceMin").val());
		params.set('priceMax', $("input#priceMax").val());
		params.set('dateMin', $("input#dateMin").val());
		params.set('dateMax', $("input#dateMax").val());
		params.set('payment', $("select#paymentMethod").val());
		params.set('currency', $("select#currency").val());
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/invoices?" + params.toString());
    })
});