$(function() {
    var categories = $(".categoriesList > div");
    categories.each(function() {
        $(this).mouseenter(function() {
            getSubCategories($(this).children("li").attr("data-category-id"), $(this).children("li"));
        });
        $("div.categories").mouseleave(function() {
            $(".category").css("height", "24px").css("display", "block");
            $("hr").css("display", "block");
            $(".category").find("div.subCategories").text("");
        });
    });

    function getSubCategories(category, currElement) {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/get-sub-categories?category-id="+category,
            success: function(result) {
                //CLEARING MENU
                categories.not(currElement.parent()).css("display", "none");
                categories.siblings().not(currElement.parent()).css("display", "none");
                currElement.parent().css("height", "100%");

                //INSERTING SUB CATEGORIES
                JSON.parse(result)[category].forEach(function(subCategory) {
                    currElement.next().append("<hr></hr><a class='subCategory' href='products-list?sub_category=" + subCategory["SubCategory"]["sub_category_name"] + "'>" + subCategory["SubCategory"]["sub_category_name"] + "</a>");
                });

                //OLD MODAL CODE
                // categories.not(currElement.parent()).children("div").css("transform", "scale(0,0)");
                // categories.not(currElement.parent()).children("div").text("");
                // if (currElement.next().text() == "") {
                //     JSON.parse(result)[category].forEach(function(subCategory) {
                //         currElement.next().append("<span class='subCategory'>"+subCategory["SubCategory"]["sub_category_name"] + "</span><br />");
                //     });
                //     currElement.next().css("transform", "scale(1,1)");
                //     $("span.subCategory").each(function() {
                //         $(this).click(function() {
                //             location.replace("http://localhost/Shop/vendor/cakephp/cakephp/products-list?sub_category="+$(this).text());    
                //         }); 
                //     });
                // } else {
                //     currElement.next().css("transform", "scale(0,0)");
                //     setTimeout(function() {
                //         currElement.next().text("");
                //     }, 250);
                // }
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
        $("div.innerSearchResults").empty();
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
                $("div.innerSearchResults").append("<p><a href='product?product_id="+data["product"+i].id+"'>"+data["product"+i].name+"</a></p>");
            }
        });
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