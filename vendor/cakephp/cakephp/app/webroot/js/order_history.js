$(function() {

    $(".order").each(function() {
        var ids = JSON.parse($(this).find("input[type=hidden]").val());
        var html = "";
        for (var i = 0; i < ids.length; i++) {
            html += `<img class='${(i > 0) ? 'd-lg-inline d-none' : ''}' src="app/webroot/img/${checkImage(ids[i])}.jpg"/>`;
        }
        $(this).find("span.images").append(html);
        $(this).find(".fa-search").each(function() {
            $(this).click(function() {
                var fields = unescape($(this).parent().parent().find(".fields").val());
				var html = '';
				var products = JSON.parse(JSON.parse(fields).Orders.products);
				if(products.length) {
					for(let i = 0; i < products.length; i++) {
						html += `<img style='height: 100px' src='app/webroot/img/${products[i].id}.jpg'><p>${products[i].count} * ${products[i].name.replaceAll('+', ' ')} - ${products[i].count * parseFloat(products[i].price.toString().replace(/[^\.\d]*/gm, ''))} ${JSON.parse(fields).Orders.currency}</p>`;
					}
				} else {
					html = `<h4>${lang.no_order_products}🤔</h4>`;
				}
                Swal.fire({
                    html: html += `<p>${JSON.parse(fields).Orders.order_points} ${JSON.parse(fields).Orders.order_points == 1 ? lang.order_points.slice(0, -1) : lang.order_points}</p>`,
                    showConfirmButton: true
                });
            });
        });
    });

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

	$('input#dateMin').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate: '0'
	});

	$('input#dateMax').datepicker({
		dateFormat: "yy-mm-dd",
		maxDate: '0'
	});

	$('input#priceMin').val(urlParams.get('priceMin'));
	$('input#priceMax').val(urlParams.get('priceMax'));
	$('input#dateMin').val(urlParams.get('dateMin'));
	$('input#dateMax').val(urlParams.get('dateMax'));

	$("select#sortHistory").find("[value='" + urlParams.get("sort_by") + "']").attr("selected", true);

    $("select#sortHistory").change(function() {
		urlParams.set('sort', $(this).val())
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/order-history?"+urlParams.toString());
    });

    $("button#filter").click(function() {
        location.replace(`${window.location.origin}${window.location.pathname}?priceMin=${$("input#priceMin").val()}&priceMax=${$("input#priceMax").val()}&dateMin=${$("input#dateMin").val()}&dateMax=${$("input#dateMax").val()}&payment=${$("select#paymentMethod").val()}&currency=${$("select#currency").val()}`);
    });

    function checkImage(id) {
        var img = new Image();
        img.src = `http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${id}.jpg`;
        return (img.height != 0) ? id : 'noimg';
    }

	$(".filter-dropdown-arrow").click(function() {
		if($("#filters").data("open")) {
			$("#filters").css("height", 0);
			$(".filter-dropdown-arrow").css("transform", "rotate(0deg)");
			$("#filters").data("open", false)
		} else {
			$("#filters").css("height", "444px");
			$(".filter-dropdown-arrow").css("transform", "rotate(90deg)");
			$("#filters").data("open", true)
		}
	});

	var page = parseInt((urlParams.get("page") != null) ? urlParams.get("page") : 1);

	$(".pagination p:not(.bold)").click(function() {
		urlParams.set("page", $(this).text());
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/order-history?" + urlParams.toString());
	});


	$(".pagination .fas").click(function() {
		if(page + $(this).data("page") != 0 && page + $(this).data("page") <= $(".pagination p").length) {
			urlParams.set("page", (page + parseInt($(this).data("page")) > 0 ? page + parseInt($(this).data("page")) : 1))
			location.replace("http://localhost/Shop/vendor/cakephp/cakephp/order-history?" + urlParams.toString());
		}
	});
});
