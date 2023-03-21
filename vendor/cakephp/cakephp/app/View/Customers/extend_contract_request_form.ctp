<?php

    echo $this->Form->create("extendContractRequestForm", array("url" => "/extend-contract-request"));
    echo $this->Form->input("employees", array("options" => $employees, "required" => true, "label" => __("employees")));
    echo $this->Form->input("extend", array("type" => "checkbox", "label" => __("extend")));
    echo $this->Form->submit(__("submit"));

    if ($this->Session->read("contractExtensionRequestSent") === true) {
        echo "<script>Swal.fire({icon: 'success',text: '".__("contract_extension_request_sent")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["contractExtensionRequestSent"] = null;
    } else if ($this->Session->read("contractExtensionRequestSent") === false) {
        echo "<script>Swal.fire({icon: 'error',text: '".__("contract_extension_request_error")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["contractExtensionRequestSent"] = null;
    }

?>