<div class="categories offset-1 col-xxl-3 col-xl-3 col-lg-4 col-10">
    <p class="categoriesBtn">Categories<i class='fas fa-angle-left'></i><i class='fas fa-angle-left'></i><i class='fas fa-angle-left'></i></p>
    <ul class="categoriesList">
        <?php
            $index = 0;
            $icons = Configure::read("icons");
            foreach ($categories as $category => $sub) {
                echo "<div class='category'><a href='products-list?category={$sub["category_id"]}'><li data-category-id='{$sub["category_id"]}' id='category-name'><i class='fa-solid fas ".$icons[$category]."'></i>".__($category)."</li></a>";
                    echo "<div class='subCategories'>";
                    for ($i = 0; $i < count($sub["sub_categories"]); $i++) {
                        echo "<li data-subcategory-id='{$sub["sub_categories"][$i]["id"]}'><a href='products-list?sub_category={$sub["sub_categories"][$i]["id"]}'>".__($sub["sub_categories"][$i]["sub_category_name"])."</a></li>";
                        if ($i < count($sub["sub_categories"]) - 1) {
                            echo "<hr />";
                        }
                    }
                    echo "</div>";
                echo "</div>";
                if ($index < count($categories) - 1) {
                    echo "<hr />";
                }
                $index++;
            }

        ?>
    </ul>
</div>
