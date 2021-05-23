$(function() {
    var categories = $(".categoriesList > div > li");
    categories.each(function() {
        $(this).bind("click", function() {
            getSubCategories($(this).attr("data-category-id"), $(this));
        });
    });

    function getSubCategories(category, currElement) {
        $.ajax({
            url: "http://localhost/Shop/vendor/cakephp/cakephp/get-sub-categories?category-id="+category,
            success: function(result) {
                categories.not(currElement).next().css("transform", "scale(0,0)");
                setTimeout(function() {
                    categories.not(currElement).next().text("");
                    if (currElement.next().text() == "") {
                        JSON.parse(result)[category].forEach(function(subCategory) {
                            currElement.next().append("<span>"+subCategory["SubCategory"]["sub_category_name"] + "</span><br />");
                        });
                        currElement.next().css("transform", "scale(1,1)");
                    } else {
                        currElement.next().css("transform", "scale(0,0)");
                        setTimeout(function() {
                            currElement.next().text("");
                        }, 250)
                    }
                }, 250);
            }
        })
    }
});