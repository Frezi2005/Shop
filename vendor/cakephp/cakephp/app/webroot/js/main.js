$(function() {

    // $("button#denie").click(() => {
    //     window.history.back();
    // })

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
        if (!localStorage.getItem("cart").length) {
            location.replace("http://localhost/Shop/vendor/cakephp/cakephp/cart");
        }
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

    $("input.searchInput").bind("keyup focus", function(e) {
        if ((e.which == 27)) {
            setTimeout(function() {
                $("div.searchResults").css("display", "none");
            }, 120);
        };
        if($(this).val().length > 0) {
            $("div.innerSearchResults").empty();
            $.ajax({
                url: "http://localhost/Shop/vendor/cakephp/cakephp/search?q=" + $(this).val(),
                dataType: "json",
                async: false,
                success: function(data) {
                    if(data.length > 0) {
                        $("div.searchResults").css("display", "block");
                        for (product of data) {
                            $("div.innerSearchResults").append(`<a href='product?product_id=${product["Products"].id}'><p title='${product["Products"].name}'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/${(product["Products"].imgExists) ? product["Products"].id : 'noimg'}.jpg'/>${product["Products"].name}</p></a>`);
                        }
                    } else {
                        $("div.searchResults").css("display", "none");
                    }
                },
                error: function(result) {
                    console.log(result);
                }
            });
        } else {
            $("div.searchResults").css("display", "none");
        }
    });

    $("input.searchInput").focusout(function() {
        setTimeout(function() {
            $("div.searchResults").css("display", "none");
        }, 120)
    });

    $(".productOnMainPage").each(function() {
        var cur = $(this);
        cur.prepend("<a href='" + cur.parent().attr("href") + "'><img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+cur.parent().attr("href").replace("product?product_id=", "")+".jpg" + "'/></a>")
    });

    if(window.history.length == 1) {
        $("#back").css("display", "none");
    }

    $("#back").click(() => {
        history.back()
    });

    // $("div.cartLink").hover(function() {
    //     $("div.cartModal").css("display", "block");
    //     var cart = JSON.parse(localStorage.getItem("cart"));
    //     if (cart.length == 0) {
    //         $("div.cartModal").css("display", "none");
    //     }
    //});

    $(".searchBtn").click(function() {
		if($("input.searchInput").val().length > 0) {
			window.location.replace("http://localhost/Shop/vendor/cakephp/cakephp/products-list?q=" + $("input.searchInput").val());
		}
	});

    $(".currencySelect").change(function() {
        var currency = $(this).val();

        if(currency !== 'USD') {
            $.ajax({
                type: "GET",
                url: `https://api.apilayer.com/fixer/latest?base=USD`,
                headers: {
                    "apikey": "CYRTNdKSEHi9b5TOKRBvEFQkMy9xishI"
                },
                success: function(data) {
                    localStorage.setItem("currency", currency);
                    localStorage.setItem("rate", data.rates[currency]);
                    location.reload();
                }
            });
        } else {
            localStorage.setItem("currency", currency);
            localStorage.setItem("rate", 1);
            location.reload();
        }
    });

	$(`.currencySelect option[value=${localStorage.getItem("currency")}]`).attr("selected", "selected");

    $(".menu i").click(function() {
        $(".hoverMenu").css("right", "0px");
    })

    $("p.close").click(function() {
        $(".hoverMenu").css("right", "-200px");
    })

    $(".productOnMainPage .price").each(function() {
        $(this).text((parseFloat($(this).text()) * localStorage.getItem("rate")).toFixed(2) + ' ' + localStorage.getItem("currency"));
    });

    var closed = true;
    $("p.categoriesBtn").click(function() {
        if(closed) {
            $(".categoriesList").css("opacity", 1);
            $(".categories").css("height", "530px")
            $(".categoriesList").css("height", "530px");
            $(".categoriesBtn > i").css("transform", "rotate(-90deg)");
            closed = false;
        } else {
            $(".categoriesList").css("opacity", 0);
            $(".categories").css("height", "50px")
            $(".categoriesList").css("height", 0);
            $(".categoriesBtn > i").css("transform", "rotate(0deg)");
            closed = true;
        }
    })
});
