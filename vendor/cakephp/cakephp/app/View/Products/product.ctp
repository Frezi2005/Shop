<?php
    echo $this->Html->css("product");
    echo $this->Html->script("product");
?>
<div class="productContainer col-xl-5 col-lg-5 col-md-6">
    <h3 id="productName"><?php echo $product["name"]; ?></h3>
    <div id="productImg"></div>
    <p id="description">Description: <?php echo $product["description"];?></p>
    <p id="priceWithoutTax">Netto: <span id="productPrice"><?php echo $product["price"] ?></span></p>
    <p id="priceWithTax"><sup>Brutto: <span id="productTaxPrice"><?php echo $product["price"] + $product["tax"]; ?></span></sup></p>
    <input type="hidden" id="productId" value="<?php echo $product["id"];?>">
    <?php
        if ($product["product_count"] > 0) {
            echo "<input type='number' name='productAmount' id='productAmount' placeholder='Max amount: ".$product['product_count']."' value='1' min='1' max='".$product['product_count']."'>";
            echo "<button id='addToCartBtn'>Add to cart</button>";
            echo "<button id='buyNowBtn'>Buy now</button>";
        } else {
            echo "<button>Zapytaj nas o dostępność</button>";
        }
    ?>
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
<div class="ad col-xl-1 col-lg-1 col-md-1 col-sm-1">
    AD
</div>