<?php

    echo $this->Html->script("order");
    echo $this->Html->css("form");
    echo $this->Html->css("order");

?>

<div id="main">
    <h1>Order page</h1>
    <div id="orderForm">
        <?php
            echo $this->Form->create("orderForm", array("url" => "/order-products"));
            echo $this->Form->input("countries", array("options" => $countries));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => "City", "required" => true, "pattern" => "[a-zA-Z\s]+"));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => "Street", "required" => true, "pattern" => "[\da-zA-Z\s]+"));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => "House number", "required" => true, "pattern" => "(([1-9])([0-9]*)[a-z]|([1-9])([0-9]*))"));
            echo $this->Form->input("flat_number", array("type" => "text", "label" => "", "placeholder" => "Flat number", "required" => true, "pattern" => "([1-9])([0-9]*)"));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email address", "required" => true, "pattern" => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}"));
            echo $this->Form->input("paymentMethod", array("options" => array("None" => "Select", "Credit card" => "Credit card", "Bank transfer" => "Bank transfer", "PayPal" => "PayPal", "BLIK" => "BLIK")));
            echo $this->Form->input("deliveryType", array("options" => array("None" => "Select", "Courier" => "Courier", "Pickup point" => "Pickup point", "Parcel locker" => "Parcel locker")));
            echo $this->Form->input("rules", array("type" => "checkbox", "label" => "I accept the <a href=\"terms-of-service\" target=\"_blank\">terms of service</a>", "required" => true));
            echo $this->Form->hidden("cart");
            echo $this->Form->hidden("price");
            echo "<span id=\"sum\"></span>";
            echo $this->Form->end("submit");
        ?>
    </div>
    <div id="paymentInfo">
        <h2>Payment Info</h2>
        <div id="info"></div>
    </div>
</div>

