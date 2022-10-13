<?php
    echo $this->Html->css("products_list");
	echo $this->Html->script("products_list");
?>

<div class="productsList offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start">
    <span id="breadcrumbs">
        <?php
            if(isset($categoryName)) {
                echo "<a href='products-list?category={$categoryId}'>".__($categoryName)."</a> <i class='fas fa-angle-right'></i> <a href='products-list?sub_category={$subCategoryId}'>".__($subCategoryName)."</a>"; 
            }
        ?>
    </span>
    <?php

        $priceAscending = __("price_ascending");
        $priceDescending = __("price_descending");
        $nameAscending = __("name_ascending");
        $nameDescending = __("name_descending");
        $next = __("next");
        $prev = __("previous");

        if($count > 1) {
            echo <<<PAG
            <div id="pagination" class="col-12">
                <select id="sort" class="col-5">
                    <option value="price_asc">$priceAscending</option>
                    <option value="price_desc">$priceDescending</option>
                    <option value="name_asc">$nameAscending</option>
                    <option value="name_desc">$nameDescending</option>
                </select>
                <button data-page-change="-1" id='page-prev' class="page-change offset-1 col-2">$prev</button>
                <button data-page-change="1" id='page-next' class="page-change offset-1 col-2">$next</button>
            </div>
            PAG;
        }

    ?>
    <input type="hidden" class="productsCount" value="<?=count($products)?>">
    <input type="hidden" class="productsShown" value="<?=$productsShown?>">
    <input type="hidden" class="totalCount" value="<?=$count?>">
    <?php
        $index = $isCategory ? "ProductsJoin" : "Product";
        foreach ($products as $product) {
            echo "<div class=\"product\"><a href=\"product?product_id=".$product[$index]["id"]."\" class='col-6'><div class=\"image\"><img src=\"app/webroot/img/".$product[$index]["id"].".jpg\"/></div><div class=\"namePriceAmount col-6\"><div class=\"first col-11\"><a href=\"product?product_id=".$product[$index]["id"]."\">".$product[$index]["name"]."</a></div><div class=\"details col-11\"><span class=\"price col-12\">".$product[$index]["price"]." USD</span><span class=\"count col-12\">".__("available").": ".$product[$index]["product_count"]."</span></div></div></a></div>";
        }
        echo "<input type=\"hidden\" id=\"subCategoryId\" value=\"$subCategoryId\">";
    ?>
</div>

