<?php
    echo $this->Html->css("products_list");
?>
<select id="sort">
    <option value="price_asc">Price ascending</option>
    <option value="price_desc">Price descending</option>
    <option value="name_asc">Name ascending</option>
    <option value="name_desc">Name descending</option>
</select>
<div class="productsList col-lg-5 col-md-5">
    <?php 
        foreach ($products as $product) {
            echo "<div class=\"product col-lg-8 col-md-8\"><div class=\"image col-lg-4 col-md-4\"><img src=\"app/webroot/img/".$product["Product"]["name"].".jpg\"/></div><div class=\"namePriceAmount col-lg-8 col-md-8\"><div class=\"first col-lg-8 col-md-8\"><a href=\"product?product_id=".$product["Product"]["id"]."\">".$product["Product"]["name"]."</a></div><div class=\"details col-lg-4 col-md-4\"><span class=\"price\">".$product["Product"]["price"]."USD</span><span class=\"count\">Available: ".$product["Product"]["product_count"]."</span></div></div></div>";
        }
        echo "<input type=\"hidden\" id=\"subCategoryId\" value=\"$subCategoryId\">";
    ?>
</div>
<button data-page-change="-1" class="page-change"><<</button>
<button data-page-change="1" class="page-change">>></button>