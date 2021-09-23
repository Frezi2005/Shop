<div class="productsList">
    <?php 
        foreach ($products as $product) {
            echo "<a href=\"product?product_id=".$product["Product"]["id"]."\">".$product["Product"]["name"]."</a><br />";
        }
    ?>
</div>