$(() => {
	var urlParams = new URLSearchParams(window.location.search);
	var page = parseInt((urlParams.get("page") != null) ? urlParams.get("page") : 1);

	$(".pagination p:not(.bold)").click(function() {
		urlParams.set("page", $(this).text());
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/inventory?" + urlParams.toString());
	});

	$(".pagination .fas").click(function() {
		if (page + $(this).data("page") != 0 && page + $(this).data("page") <= $(".pagination").data("count")) {
			urlParams.set("page", (page + parseInt($(this).data("page")) > 0 ? page + parseInt($(this).data("page")) : 1))
			location.replace("http://localhost/Shop/vendor/cakephp/cakephp/inventory?" + urlParams.toString());
		}
	});
});
