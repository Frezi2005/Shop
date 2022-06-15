<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1>Change address</h1>
    <div id="changeAddressForm">
        <?php
            echo $this->Form->create("changeAddressForm", array("url" => "/change-address"));
            echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => "Country"));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => "City"));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => "Street"));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => "House number"));
            echo $this->Form->input("flat_number", array("type" => "text", "label" => "", "placeholder" => "Flat number"));

            echo $this->Form->end("submit");
        ?>
    </div>
</div>