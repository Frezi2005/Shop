$(() => {
	$(".product .price").each(function() {
		$(this).text((parseFloat($(this).text()) * localStorage.getItem("rate")).toFixed(2) + '\n' + localStorage.getItem("currency"));
	});

	if(!+$(".productsCount").val()) {
		$(".productsList").hide();
		$("#content").append("<span class='noProducts'>Looks like there's currently no products in this category!</span>")
	}

});
