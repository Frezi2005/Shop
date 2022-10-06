<?php
    echo $this->Html->css("product");
    echo $this->Html->script("product");
?>
<div class="productContainer offset-1 col-xxl-6 col-xl-6 col-lg-5 col-4">
    <h3 id="productName" class="col-12"><?php echo $product["name"]; ?></h3>
    <div id="productImg" class="col-xxl-6 col-xl-6 col-lg-12 col-12 float-start"></div>
    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12 float-start">
        <p id="description" class=""><?=__("description")?>: <?php echo $product["description"];?></p>
        <p id="priceWithoutTax"><?=__("netto_price")?>: <span id="productPrice"><?php echo $product["price"] ?> USD</span></p>
        <p id="priceWithTax"><sup><?=__("brutto_price")?>: <span id="productTaxPrice"><?php echo $product["price"] + $product["tax"]; ?> USD</span></sup></p>
        <input type="hidden" id="productId" value="<?php echo $product["id"];?>">
        <?php
            if ($product["product_count"] > 0) {
                echo "<input type='number' name='productAmount' class='col-xxl-3 col-xl-4 col-lg-5 col-12 mb-3' id='productAmount' placeholder='".__("max_amount")." ".$product['product_count']."' value='1' min='1' max='".$product['product_count']."'>";
                echo "<div class='row'>";
                echo "<button id='addToCartBtn' class='offset-lg-1 col-lg-4 col-12 mx-2 mb-lg-0 mb-3'>".__("add_to_cart")."</button>";
                echo "<button id='buyNowBtn' class='offset-lg-2 col-lg-4 col-12 mx-2'>".__("buy_now")."</button>";
                echo "</div>";
            } else {
                echo "<button id='ask'>".__("ask_for_availability")."</button>";
            }
        ?>
        </div>
    <ul>
    <?php

        if (is_array($product["specs"])) {
            $specs = json_decode($product["specs"], true)[0];
            foreach ($specs as $spec => $val) {
                echo "<li>".$spec.": ".$val."</li>";
            }
        }

    ?>
    </ul>
</div>
