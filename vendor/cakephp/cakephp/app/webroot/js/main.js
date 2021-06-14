$(function() {
    var categories = $(".categoriesList > div");
    categories.each(function() {
        $(this).hover(function() {
            getSubCategories($(this).children("li").attr("data-category-id"), $(this).children("li"));
        });
    });

    function getSubCategories(category, currElement) {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/get-sub-categories?category-id="+category,
            success: function(result) {
                categories.not(currElement.parent()).children("div").css("transform", "scale(0,0)");
                categories.not(currElement.parent()).children("div").text("");
                if (currElement.next().text() == "") {
                    JSON.parse(result)[category].forEach(function(subCategory) {
                        currElement.next().append("<span>"+subCategory["SubCategory"]["sub_category_name"] + "</span><br />");
                    });
                    currElement.next().css("transform", "scale(1,1)");
                } else {
                    currElement.next().css("transform", "scale(0,0)");
                    setTimeout(function() {
                        currElement.next().text("");
                    }, 250);
                }
            }
        })
    }

    var languageSelect = $("select.languageSelect");

    languageSelect.change(function() {
        changeLanguage(languageSelect.val());
    })

    function changeLanguage(lang) {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/change-language?lang="+lang,
            success: function(result) {
                location.reload();
            }
        });
    }

    $("input.searchInput").on("keyup", function() {
        $("div.searchResults").empty();
        $.getJSON("http://localhost/Shop/vendor/cakephp/cakephp/search?q="+$(this).val(), function(data) {
            var len = Object.keys(data).length;
            for (var i = 0; i < len; i++) {
                for (var j = 0; j < len - i - 1; j++) { 
                    if (data["product"+j].totalScore < data["product"+(j+1)].totalScore) {
                        var temp = data["product"+j];
                        data["product"+j] = data["product"+(j+1)];
                        data["product"+(j+1)] = temp;
                    }
                }
            }
            $("div.searchResults").css("display", "block");
            for(var i = 0; i < Object.keys(data).length; i++) {
                $("div.searchResults").append("<p><a href='product?product_id="+data["product"+i].id+"' target='_blank'>"+data["product"+i].name+"</a></p>");
            }
      });
    });
});