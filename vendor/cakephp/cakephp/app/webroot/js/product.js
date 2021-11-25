$(function (){
    $("#productAmount").on("input", function() {
        if (parseInt($(this).val()) > parseInt($(this).attr("max"))) {
            $(this).val($(this).attr("max"));
        } 
    });
        
    $("#addToCartBtn").click(function() {
        addToCart();
    });

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var page = parseInt((urlParams.get("p") != null) ? urlParams.get("p") : 1);
    var newUrl;

    $("select#sort").find("[value='" + urlParams.get("sort_by") + "']").attr("selected", true);
    //console.log(urlParams.get("sort_by"));

    $("button.page-change").click(function() {
        newUrl = queryString.replace(/&p=\d{1,}/, "") + "&p=" + (((page + parseInt($(this).data("page-change"))) > 0) ? (page + parseInt($(this).data("page-change"))) : 1);
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/products-list"+newUrl);
    })

    $("select#sort").change(function() {
        newUrl = queryString.replace("&sort_by="+urlParams.get("sort_by"), "&sort_by=" + $(this).val());
        //$(this).find("[value='" + $(this).val() + "']").attr("selected", true);
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/products-list"+newUrl);
    });

    $.ajax({
        type: "GET",
        url: "http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+$("#productName").text()+".jpg",
        success: function(data) {
            $("div#productImg").append("<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+$("#productName").text()+".jpg" + "'/>")
        },
        error: function(e) {
            $("div#productImg").append("<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/noimg.jpg'/>")
        }
    });

    displayAmount(items);
    displayItemsInCartGUI(items);
});

var items = (JSON.parse(localStorage.getItem("cart")) == null) ? [] : JSON.parse(localStorage.getItem("cart"));

function addToCart() {
    var amount = $("input#productAmount").val();
    if (amount.match(/^[1-9][0-9]{0,}$|^[1-9][0-9]{0,}$/gm)) {
        var existsInCart;
        if (JSON.parse(localStorage.getItem("cart")) == null) {
            localStorage.setItem("cart", JSON.stringify([]));
        }
        if (items.length == 0) {
            items.push({
                    id: $("#productId").val(),
                    name: $("#productName").text(),
                    price: $("#productPrice").text(),
                    count: parseInt(amount)
                }
            );
        } else {
            for (var i = 0; i < items.length; i++) {
                if ($("#productId").val() == items[i].id) {
                    existsInCart = true;
                    items[items.findIndex(x => x.id == $("#productId").val())].count += parseInt(amount);
                    break;
                } else {
                    existsInCart = false;
                }
            }
            if(!existsInCart) {
                items.push({
                        id: $("#productId").val(),
                        name: $("#productName").text(),
                        price: $("#productPrice").text(),
                        count: parseInt(amount)
                    }
                );
            }
        }
        Swal.fire({
            icon: "success",
            text: "This item has been successfully added to your cart: " + $("#productName").text(),
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
        localStorage.setItem("cart", JSON.stringify(items));
        displayAmount(items);
        displayItemsInCartGUI(items);
    } else {
        Swal.fire({
            icon: "error",
            text: "Products amount can't have letters, be empty or be 0!",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    }
}

function removeFromCart(id) {
    var cart = (JSON.parse(localStorage.getItem("cart")) == null) ? [] : JSON.parse(localStorage.getItem("cart"));
    var itemIndex = cart.findIndex(x => x.id == id);
    cart.splice(itemIndex, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayAmount(items);
    displayItemsInCartGUI(items);
}

function displayAmount(cart) {
    var amount = 0;
    for (var i = 0; i < cart.length; i++) {
        amount += cart[i].count;
    }
    $("#cartProductsAmount").text(amount);
}

function displayItemsInCartGUI(cart) {
    $(".cartModal").text("");
    var sum = 0;
    if (cart.length > 0 || cart != null) {
        for (var i = 0; i < cart.length; i++) {
            sum += parseInt(cart[i].count) * parseFloat(cart[i].price); 
            $(".cartModal").append("<div><p title='"+cart[i].name+"'>"+cart[i].name+"</p><br/><span>"+cart[i].count+"</span><span>"+cart[i].price+"USD</span></div>");
        }

        $(".cartModal").append("<span>Total: "+sum+"USD</span>");
    }
}

displayItemsInCartGUI(items);
displayAmount(items);