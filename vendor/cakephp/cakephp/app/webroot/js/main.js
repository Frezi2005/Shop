//Function for counting business days between 2 dates
function getBusinessDatesCount(startDate, endDate) {
    let count = 0;
    const curDate = new Date(startDate.getTime());
    while (curDate <= endDate) {
        const dayOfWeek = curDate.getDay();
        if (dayOfWeek !== 0 && dayOfWeek !== 6) count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    return count;
}

$(function() {

    // $("button#denie").click(() => {
    //     window.history.back();
    // })

	//Rodo handling
    $("button#accept").click(() => {
        $.get("create-rodo-cookie");
        $("div#rodo").css("display", "none");
    });

    if (document.cookie.indexOf("[rodo_accepted]=1") != -1) {
        $("div#rodo").css("display", "none");
    } else {
        $("div#rodo").css("display", "block");
    }

	//Showing subcategories on categories hover
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

	//Function for changing the language
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
        if ($(this).val().length > 0) {
            $("div.innerSearchResults").empty();
            $.ajax({
                url: "http://localhost/Shop/vendor/cakephp/cakephp/search?q=" + $(this).val(),
                dataType: "json",
                async: false,
                success: function(data) {
                    if (data.length > 0) {
                        $("div.searchResults").css("display", "block");
                        for (product of data) {
							console.log(product);
                            $("div.innerSearchResults").append(
								`<a href='product?product_id=${product["Products"].id}'>
									<p title='${product["Products"].name}'>
										<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/
											${(product["Products"].imgExists) ? product["Products"].id : 'noimg'}.jpg'/>
										${product["Products"].name}
									</p>
								</a>
							`);
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

    $(".img-text .currency").each(function () {
        $(this).text(localStorage.getItem("currency"));
    })

    $(".img-text .price").each(function () {
        $(this).text(($(this).text() * localStorage.getItem("rate")).toFixed(2));
    })

    $(".productOnMainPage").each(function() {
        var cur = $(this);
        cur.prepend(`
			<a href='${cur.parent().attr("href")}'>
				<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/
					${cur.parent().attr("href").replace("product?product_id=", "")}.jpg'/>
			</a>
		`)
    });

    if (window.history.length == 1) {
        $("#back").css("display", "none");
    }

    $("#back").click(() => {
        history.back()
    });

    $("div.cartLink").hover(function() {
        var cart = JSON.parse(localStorage.getItem("cart"));
        if (cart.length > 0) {
            $("div.cartModal").css("display", "block");
        }
    });

    $("div.cartLink").mouseleave(function() {
        $("div.cartModal").css("display", "none");
    })

    $(".searchBtn").click(function() {
		$("input.searchInput").focus();
		if ($("input.searchInput").val().length > 0) {
			window.location.replace(`http://localhost/Shop/vendor/cakephp/cakephp/products-list?
			q=${$("input.searchInput").val()}
		`);
		}
	});

    $(".currencySelect").change(function() {
        var currency = $(this).val();

        if (currency !== 'USD') {
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
		$("body").css("overflow-y", "hidden");
    })

    $(".close").click(function() {
        $(".hoverMenu").css("right", "-100%");
		$("body").css("overflow-y", "auto");
    })

    $(".productOnMainPage .price").each(function() {
        $(this).text((parseFloat($(this).text()) * localStorage.getItem("rate")).toFixed(2) + ' ' +
			localStorage.getItem("currency"));
    });

    var closed = true;
    $("p.categoriesBtn").click(function() {
        if (closed) {
            // $(".categoriesList").css("display", "block");
            $(".categories").css("height", "530px")
            $(".categoriesList").css("height", "530px");
            $(".categoriesBtn > i").css("transform", "rotate(-90deg)");
            closed = false;
        } else {
            // $(".categoriesList").css("display", "none");
            $(".categories").css("height", "50px")
            $(".categoriesList").css("height", "0px");
            $(".categoriesBtn > i").css("transform", "rotate(0deg)");
            closed = true;
        }
    })

    $(".logInLink").click(() => {
        location.replace(`http://localhost/Shop/vendor/cakephp/cakephp/${$($(".logInLink").find("a")[0]).attr("href")}`);
    })
});
