<?php

    echo $this->Html->script("order");
    echo $this->Html->css("form")

?>

<span id="sum"></span>
<div id="main">
    <h1>Order page</h1>
    <div id="orderForm">
        <?php
            echo $this->Form->create("orderForm", array("url" => "/order-products"));
            echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => "Country"));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => "City"));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => "Street"));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => "House number"));
            echo $this->Form->input("paymentMethod", array("options" => array("Credit card" => "Credit card", "Bank transfer" => "Bank transfer", "PayPal" => "PayPal", "PaySafeCard" => "PaySafeCard", "BLIK" => "BLIK")));
            echo $this->Form->input("deliveryType", array("options" => array("Courier" => "Courier", "Pickup point" => "Pickup point", "Parcel locker" => "Parcel locker")));
            echo $this->Form->hidden("cart");
            echo $this->Form->hidden("price");
            echo $this->Form->end("submit");
        ?>
    </div>
</div>
