<?php

    echo $this->Html->script("order");
    echo $this->Html->css("form");
    echo $this->Html->css("order");
?>

<div class="main offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start">
    <h1 class="ms-3"><?=__("order_form")?></h1>
    <div id="orderForm" class="col-6">
        <?php

            $url = (isset($_SESSION["userUUID"])) ? "/order-products" : "/ask-for-account";

            echo $this->Form->create("orderForm", array("url" => $url));
            echo $this->Form->input("countries", array("options" => $countries, "label" => __("countries"), "required" => true, "value" => isset($userInfo) ? $userInfo["country"] : ""));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => __("city"), "required" => true, "pattern" => "[a-zA-Z\s]+", "value" => isset($userInfo) ? $userInfo["country"] : ""));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => __("street"), "required" => true, "pattern" => "[\da-zA-Z\s]+", "value" => isset($userInfo) ? $userInfo["street"] : ""));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => __("house_number"), "required" => true, "pattern" => "(([1-9])([0-9]*)[a-z]|([1-9])([0-9]*))", "value" => isset($userInfo) ? $userInfo["house_number"] : ""));
            echo $this->Form->input("flat_number", array("type" => "text", "label" => "", "placeholder" => __("flat_number"), "required" => true, "pattern" => "([1-9])([0-9]*)", "value" => isset($userInfo) ? $userInfo["flat_number"] : ""));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => __("email"), "required" => true, "pattern" => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}", "value" => isset($userInfo) ? $userInfo["email"] : ""));
            echo $this->Form->input("paymentMethod", array("label" => __("payment_method"), "options" => array("" =>  __("payment_method"), "credit_card" => __("credit_card"), "bank_transfer" => __("bank_transfer"), "PayPal" => "PayPal", "BLIK" => "BLIK"), "required" => true));
            echo $this->Form->input("deliveryType", array("label" => __("delivery_type"), "options" => array("" => __("delivery_type"), "courier" => __("courier"), "pickup_point" => __("pickup_point"), "parcel_locker" => __("parcel_locker")), "required" => true));
			echo "<label id='checkboxError'>".__("agree_to_tos")."</label>";
			echo $this->Form->input("rules", array("type" => "checkbox", "label" => __("tos")));
            echo $this->Form->hidden("cart");
            echo $this->Form->hidden("price");
			echo $this->Form->hidden("currency");
            echo "<span id=\"sum\"></span>";
            echo $this->Form->end(__("order"));
        ?>
    </div>
    <div id="paymentInfo" class="offset-1 col-5 float-start">
        <h2><?=__("payment_info")?></h2>
        <div id="info"></div>
    </div>
</div>


