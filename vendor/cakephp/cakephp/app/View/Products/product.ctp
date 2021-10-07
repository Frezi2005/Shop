<?php
    echo $this->Html->css("product");
    echo $this->Html->script("product");
?>
<div class="productContainer w-auto">
    <h3 id="productName"><?php echo $product["name"]; ?></h3>
    <?php echo $this->Html->image($product["name"].".jpg", array("alt" => "Product image")); ?>
    <p id="description">Description: <?php echo $product["description"];?></p>
    <p id="priceWithoutTax">Netto: <span id="productPrice"><?php echo $product["price"] ?></span></p>
    <p id="priceWithTax"><sup>Brutto: <?php echo $product["price"] + $product["tax"]; ?></sup></p>
    <input type="hidden" id="productId" value="<?php echo $product["id"];?>">
    <input type="number" name="productAmount" id="productAmount" value="1" min="1" max="<?php echo $product["product_count"];?>">
    <button id="addToCartBtn">Add to cart</button>
    <button id="buyNowBtn">Buy now</button>
    <ul>
    <?php 
        $specs = json_decode($product["specs"], true)[0];
        foreach($specs as $spec => $val) {
            echo "<li>".$spec.": ".$val."</li>";
        }
    ?>
    </ul>
</div>