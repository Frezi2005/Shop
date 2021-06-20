$(function() {
    $("#productNumber").bind("keyup keydown", function() {
        if ($(this).val() > $(this).attr("max")) {
            $(this).val($(this).attr("max"));
        } 
    });

    var items = (JSON.parse(localStorage.getItem("cart")) == null) ? [] : JSON.parse(localStorage.getItem("cart"));

    $("#addToCartBtn").click(function() {
        addToCart();
    });

    $("#viewCart").click(function() {
        showCart();
    });

    function showCart() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        console.log(cart);
    }

    function addToCart() {
        var exists;
        if (JSON.parse(localStorage.getItem("cart")) == null) {
            localStorage.setItem("cart", JSON.stringify([]));
        }
        if (items.length == 0) {
            items.push({
                    id: $("#productId").val(),
                    name: $("#productName").text(),
                    price: $("#productPrice").text(),
                    count: 1
                }
            );
        } else {
            for (var i = 0; i < items.length; i++) {
                if ($("#productId").val() == items[i].id) {
                    exists = true;
                    items[items.findIndex(x => x.id == $("#productId").val())].count++;
                    break;
                } else {
                    exists = false;
                }
            }
            if(!exists) {
                items.push({
                        id: $("#productId").val(),
                        name: $("#productName").text(),
                        price: $("#productPrice").text(),
                        count: 1
                    }
                );
            }
        }
        Swal.fire({
            icon: "success",
            text: "This item has been successfully added to your cart: "+$("#productName").text(),
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        localStorage.setItem("cart", JSON.stringify(items));
        displayAmount();
    }

    function removeFromCart() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        var itemIndex = cart.findIndex(x => x.id == "2d27d262-c701-11eb-a8c6-9822efb9cbff");
        cart.splice(itemIndex, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        displayAmount();
    }

    function displayAmount() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        var amount = 0;
        for (var i = 0; i < cart.length; i++) {
            amount += cart[i].count;
        }
        $("#cartProductsAmount").text(amount);
    }

    function displayItemsInCartGUI() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        var sum = 0;
        for (var i = 0; i < cart.length; i++) {
            sum += parseInt(cart[i].count) * parseFloat(cart[i].price); 
            $(".cartModal").append("<div><p title='"+cart[i].name+"'>"+cart[i].name+"</p><br/><span>"+cart[i].count+"</span><span>"+cart[i].price+"USD</span></div>");
        }

        $(".cartModal").append("<span>Total: "+sum+"USD</span>");
    }

    displayItemsInCartGUI();
    displayAmount();
    
});