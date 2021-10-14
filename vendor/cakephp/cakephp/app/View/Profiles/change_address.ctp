<?php
    echo $this->Form->create("changeAddressForm", array("url" => "/register-customer"));
    echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => "Country input"));
    echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => "City input"));
    echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => "Street input"));
    echo $this->Form->input("houseNumber", array("type" => "number", "label" => "", "placeholder" => "House number input"));
    echo $this->Form->input("flatNumber", array("type" => "number", "label" => "", "placeholder" => "Flat number input"));

    echo $this->Form->end("submit");
?>