$(() => {
    var params = new URLSearchParams(window.location.search);

    $("#filter").click(function() {
        params.set("type", encodeURI(JSON.stringify($("#messageType").val())))
		params.set("page", 1);
        location.replace(`${window.location.origin}${window.location.pathname}?${params.toString()}`);
    });

	var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);
	var page = parseInt((urlParams.get("page") != null) ? urlParams.get("page") : 1);

	$("select#sort").find("[value='" + urlParams.get("sort_by") + "']").attr("selected", true);

	$("select#sort").change(function() {
		urlParams.set('sort_by', $(this).val())
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/view-messages?"+urlParams.toString());
	});

	$(".pagination p:not(.bold)").click(function() {
		urlParams.set("page", $(this).text());
		location.replace("http://localhost/Shop/vendor/cakephp/cakephp/view-messages?" + urlParams.toString());
	});

	$(".pagination .fas").click(function() {
		if (page + $(this).data("page") != 0 && page + $(this).data("page") <= $(".pagination p").length) {
			urlParams.set("page", (page + parseInt($(this).data("page")) > 0 ? page + parseInt($(this).data("page")) : 1))
			location.replace("http://localhost/Shop/vendor/cakephp/cakephp/view-messages?" + urlParams.toString());
		}
	});
});
