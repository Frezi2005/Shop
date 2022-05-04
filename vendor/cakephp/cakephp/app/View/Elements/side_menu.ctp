<div class="categories col-xl-2 col-lg-3 col-md-5 col-sm-5">			
    <ul class="categoriesList">
        <?php 
            $index = 0;
            foreach ($categories as $category => $sub) {
                echo "<div class='category'><li data-category-id='{$sub["category_id"]}' id='category-name'>".__($category)."</li>";
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