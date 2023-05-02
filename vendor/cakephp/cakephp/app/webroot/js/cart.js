$(function() {
    var cart = (JSON.parse(localStorage.getItem("cart")) == null) ?
		history.back() :
		JSON.parse(localStorage.getItem("cart"));
    var sum = 0;

    for (var i = 0; i < cart.length; i++) {
        sum += parseInt(cart[i].count) * parseFloat(cart[i].price);
        $(".products").append(`
			<div class='product m-2'>
				<div class='row'>
					<p class='productName float-start col-12' title='${cart[i].name}'>
						<i class='fas fa-trash-alt trashIcon float-end' data-product-id='${cart[i].id}'></i>
						${cart[i].name}
					</p>
				</div>
				<div class='row'>
					<span class='productCount text-start col-6'>${cart[i].count}</span>
					<span class='productPrice text-end col-6'>${cart[i].price} ${localStorage.getItem("currency")}</span>
				</div>
			</div>
		`);
    }

    if (!sum || sum == null) {
        history.back();
    }

    $(".products").append(`
		<span class="m-2">
			Total: ${Math.round((sum + Number.EPSILON) * 100) / 100} ${localStorage.getItem("currency")}
		</span>
	`);

    $(".trashIcon").each(function () {
        $(this).click(function () {
            removeFromCart($(this).data("product-id"));
            var newSum = 0;
            for (var i = 0; i < JSON.parse(localStorage.getItem("cart")).length; i++) {
                newSum += parseInt(JSON.parse(localStorage.getItem("cart"))[i].count) *
					parseFloat(JSON.parse(localStorage.getItem("cart"))[i].price);
            }
            $(".products > span").text(Math.round((newSum + Number.EPSILON) * 100) / 100);
            $(this).parent().parent().remove();
            displayItemsInCartGUI(cart);
            displayAmount(cart);
        });
    });

    $("button#order").click(function() {
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/order");
    });
});
