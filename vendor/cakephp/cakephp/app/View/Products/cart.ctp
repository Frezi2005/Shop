<?php
    echo $this->Html->css("cart");
    echo $this->Html->script("cart");
    echo $this->Html->script("product");
?>
<div class="cartContainer offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10">
    <div class="products"></div>
    <button id="order" class="m-2 col-xxl-2 col-xl-2 col-lg-3 col-md-5 col-12"><?=__("order")?></button>
</div>
