$(function() {
    var categories = $(".categoriesList > li");
    var open = false;
    categories.each(function() {
        $(this).click(function() {
            var subCategoriesList = $(this).next();
            openCategory(subCategoriesList);
        })
    });

    function openCategory(subCategoriesList) {
        if(open == false) {
            console.log(subCategoriesList.css("height", subCategoriesList.children().length * 25));
            open = true;
        } else {
            console.log(subCategoriesList.css("height", 0));
            open = false;
        }
    }

});