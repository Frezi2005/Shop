$(() => {

	//Handling of sortin and filters default values
    let params = new URLSearchParams(window.location.search);

    $('input#priceMin').val(params.get('priceMin'));
	$('input#priceMax').val(params.get('priceMax'));
	$('input#dateMin').val(params.get('dateMin'));
	$('input#dateMax').val(params.get('dateMax'));
	$('select#paymentMethod').val(params.get('payment'));
	$('select#currency').val(params.get('currency'));
	$('select#sort').val(params.get('sort_by') ?? 'order_date-desc');

    $("#filter").click(function () {
		if (
			!$("input#priceMin").val() &&
			!$("input#priceMax").val() &&
			!$("input#dateMin").val()  &&
			!$("input#dateMax").val() &&
			!$("select#paymentMethod").val() &&
			!$("select#currency").val() &&
			!$("select#sort").val()
		) {
			location.replace("http://localhost/Shop/vendor/cakephp/cakephp/invoices");
		} else {
			params.set('priceMin', $("input#priceMin").val());
			params.set('priceMax', $("input#priceMax").val());
			params.set('dateMin', $("input#dateMin").val());
			params.set('dateMax', $("input#dateMax").val());
			params.set('payment', $("select#paymentMethod").val());
			params.set('currency', $("select#currency").val());
			params.set("sort_by", $("#sort").val());
			location.replace("http://localhost/Shop/vendor/cakephp/cakephp/invoices?" + params.toString());
		}
    })
});
