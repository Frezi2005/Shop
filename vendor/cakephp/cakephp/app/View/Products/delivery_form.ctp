<?php

    echo $this->Html->script("delivery_form");

    echo $this->Form->create("deliveryForm", array("url" => "/add-products-from-delivery"));
    echo $this->Form->input("products", array("options" => $products, "multiple" => true));
    echo $this->Form->input("count", array("type" => "number", "label" => "", "placeholder" => "Number of products"));
    echo $this->Form->end("submit");

    if ($this->Session->read("numberError") == true) {
        echo "<script>Swal.fire({icon: \"error\",text: \"Products count is invalid!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["numberError"] = false;
    }
?>