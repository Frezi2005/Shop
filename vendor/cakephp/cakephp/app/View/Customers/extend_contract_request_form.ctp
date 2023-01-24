<?php

    echo $this->Form->create("extendContractRequestForm", array("url" => "/extend-contract-request"));
    echo $this->Form->input("employees", array("options" => $employees, "required" => true, "label" => __("employees")));
    echo $this->Form->input("extend", array("type" => "checkbox", "label" => __("extend")));
    echo $this->Form->submit(__("submit"));

?>