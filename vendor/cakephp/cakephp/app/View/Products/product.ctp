<?php
    echo $this->Html->css("product");
    echo $this->Html->script("product");
?>
<span id="viewCart">VIEW CART</span>
<h3 id="productName"><?php echo $product["name"]; ?></h3>
<?php echo $this->Html->image($product["name"].".jpg", array("alt" => "Product image")); ?>
<p>Description: <?php echo $product["description"];?></p>
<p>Netto: <span id="productPrice"><?php echo $product["price"] ?></span></p>
<sup>Brutto: <?php echo $product["price"] + $product["tax"]; ?></sup>
<button id="addToCartBtn">Add to cart</button>
<button>Buy now</button>
<input type="hidden" id="productId" value="<?php echo $product["id"];?>">
<input type="number" name="productNumber" id="productNumber" max="<?php echo $product["product_count"];?>">
