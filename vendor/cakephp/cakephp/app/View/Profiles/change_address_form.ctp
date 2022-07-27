<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1><?=__("change_address_form")?></h1>
    <div id="changeAddressForm">
        <?php
            echo $this->Form->create("changeAddressForm", array("url" => "/change-address"));
            echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => __("country")));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => __("city")));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => __("street")));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => __("house_number")));
            echo $this->Form->input("flat_number", array("type" => "text", "label" => "", "placeholder" => __("flat_number")));

            echo $this->Form->end(__("submit"));
        ?>
    </div>
</div>
