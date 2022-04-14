$(function() {

    $("button#denie").click(() => {
        window.history.back();
    })

    $("button#accept").click(() => {
        $.get("create-rodo-cookie");
        $("div#rodo").css("display", "none");
    });

    if(document.cookie.indexOf("[rodo_accepted]=1") != -1) {
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
        $.getJSON("http://localhost/Shop/vendor/cakephp/cakephp/search?q=" + $(this).val(), function(data) {
            var len = 10; //Object.keys(data).length;
            for (var i = 0; i < Object.keys(data).length; i++) {
                for (var j = 0; j < Object.keys(data).length - i - 1; j++) { 
                    if (data["product"+j].totalScore < data["product"+(j+1)].totalScore) {
                        var temp = data["product"+j];
                        data["product"+j] = data["product"+(j+1)];
                        data["product"+(j+1)] = temp;
                    }
                }
            }
            $("div.searchResults").css("display", "block");
            for(var i = 0; i < len; i++) {
                $("div.innerSearchResults").append("<p><a href='product?product_id="+data["product"+i].id+"'>"+data["product"+i].name+"<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/" + checkImage(data["product"+i].id) + ".jpg'/></a></p>");
            }
        });
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

    var img;

    function checkImage(productId) {
        img = null;
        $.ajax({
            async: false,
            url: "http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/"+productId+".jpg",
            error: function(request, status, error){
                img = status; 
            }
        });
        return img == "error" ? "noimg" : productId;
    }


    $("#back").click(() => {
        history.back()
    });

    //NUMBER BUTTONS PAGE CHANGING SYSTEM

    // per_page = parseInt((per_page != null) ? per_page : 10);
    // page = parseInt((page != null) ? page : 1);

    // console.log(queryString);
    // console.log(per_page);
    // console.log(page);

    // $.ajax({
    //     url: "http://localhost/Shop/vendor/cakephp/cakephp/return-products-count?id="+$("input#subCategoryId").val(),
    //     success: function(result) {
    //         console.log(result);
    //     }
    // });
});