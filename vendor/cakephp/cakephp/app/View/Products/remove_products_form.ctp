<?php

    echo $this->Form->create("removeProductsForm", array("url" => "/remove-products"));
    echo $this->Form->input("products", array("options" => $products, "multiple" => true));
    echo $this->Form->end("delete");

?>