<?php
    echo $this->Html->css("products_list");
	echo $this->Html->script("products_list");
?>
<div class="productsList offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start">
    <input type="hidden" class="productsCount" value="<?=count($products)?>">
    <input type="hidden" class="productsShown" value="<?=$productsShown?>">
    <?php
        foreach ($products as $product) {
            echo "<div class=\"product\"><a href=\"product?product_id=".$product["Product"]["id"]."\" class='col-6'><div class=\"image\"><img src=\"app/webroot/img/".$product["Product"]["id"].".jpg\"/></div><div class=\"namePriceAmount col-6\"><div class=\"first col-lg-8 col-md-8\"><a href=\"product?product_id=".$product["Product"]["id"]."\">".$product["Product"]["name"]."</a></div><div class=\"details col-lg-4 col-md-4\"><span class=\"price\">".$product["Product"]["price"]."USD</span><span class=\"count\">Available: ".$product["Product"]["product_count"]."</span></div></div></a></div>";
        }
        echo "<input type=\"hidden\" id=\"subCategoryId\" value=\"$subCategoryId\">";
    ?>
</div>
<div id="pagination">
    <select id="sort">
        <option value="price_asc"><?=__("price_ascending")?></option>
        <option value="price_desc"><?=__("price_descending")?></option>
        <option value="name_asc"><?=__("name_ascending")?></option>
        <option value="name_desc"><?=__("name_descending")?></option>
    </select>
    <button data-page-change="-1" class="page-change"><<</button>
    <button data-page-change="1" class="page-change">>></button>
</div>
