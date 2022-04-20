$(function() {

    $("button#denie").click(() => {
        window.history.back();
    })

    $("button#accept").click(() => {
        $.get("create-rodo-cookie");
        $("div#rodo").css("display", "none");
    });

    if (document.cookie.indexOf("[rodo_accepted]=1") != -1) {
        $("div#rodo").css("display", "none");
    } else {
        $("div#rodo").css("display", "block");
    }

    $(".categoriesList > .category").each(function() {
        var categoriesDiv = $(this).children().next();
        $(this).mouseover(function() {
            categoriesDiv.css("opacity", "1");
            categoriesDiv.css("display", "block");
        });

        categoriesDiv.mouseover(function() {
            categoriesDiv.css("opacity", "1");
            categoriesDiv.css("display", "block");
        });

        $(this).mouseout(function() {
            categoriesDiv.css("opacity", "0");
            categoriesDiv.css("display", "none");
        });

        categoriesDiv.mouseout(function() {
            categoriesDiv.css("opacity", "0");
            categoriesDiv.css("display", "none");
        });
    });

    $("#linkOuter").click(function() {
        location.replace("http://localhost/Shop/vendor/cakephp/cakephp/cart");
    });

    var languageSelect = $("select.languageSelect");

    languageSelect.change(function() {
        changeLanguage(languageSelect.val());
    })

    function changeLanguage(lang) {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/change-language?lang=" + lang,
            success: function(result) {
                location.reload();
            }
        });
    }

    $("input.searchInput").bind("keyup focus", function() {
        $("div.innerSearchResults").empty();
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/search?q=" + $(this).val(),
            dataType: "json",
            async: false,
            success: function(data) {
                $("div.searchResults").css("display", "block");
                for (product of data) {
                    $("div.innerSearchResults").append(`<p title='${product["Products"].name}'><a href='product?product_id=${product["Products"].id}'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${checkImage(product["Products"].id)}.jpg'/>${product["Products"].name}</a></p>`);
                }
            },
            error: function(result) {
                console.log(result);
            }
        })
    });

    $("input.searchInput").focusout(function() {
        setTimeout(function() {
            $("div.searchResults").css("display", "none");
        }, 120)
    });

    $(".productOnMainPage").each(function() {
        var cur = $(this);
        $.ajax({
            type: "GET",
            url: "http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+cur.find("a").text()+".jpg",
            success: function(data) {
                cur.prepend("<a href='" + cur.find("a").attr("href") + "'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+cur.find("a").text()+".jpg" + "'/></a>")
            },
            error: function(e) {
                $.ajax({
                    type: "GET",
                    url: "http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+cur.find("a").attr("href").replace("product?product_id=", "")+".jpg",
                    success: function(data) {
                        cur.prepend("<a href='" + cur.find("a").attr("href") + "'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+cur.find("a").attr("href").replace("product?product_id=", "")+".jpg" + "'/></a>")
                    },
                    error: function(e) {
                        cur.prepend("<a href='" + cur.find("a").attr("href") + "'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/noimg.jpg'/></a>")
                    }
                });
            }
        });
    });

    function checkImage(id) {
        var img = new Image();
        img.src = `http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${id}.jpg`;
        return (img.height != 0) ? id : 'noimg';
    }

    $("#back").click(() => {
        history.back()
    });

    $("div.cartLink").hover(function() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        if (cart.length == 0) {
            $("div.cartModal").css("display", "none");
        } else {
            $("div.cartModal").css("display", "block");
        }
    });

    $(".searchBtn").click(function() {
        window.location.replace("http://localhost/Shop/vendor/cakephp/cakephp/products-list?q=" + $("input.searchInput").val());
    });
});