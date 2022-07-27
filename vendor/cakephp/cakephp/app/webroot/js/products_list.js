$(() => {
	$(".product .price").each(function() {
		$(this).text((parseFloat($(this).text()) * localStorage.getItem("rate")).toFixed(2)+localStorage.getItem("currency"));
	});
});
