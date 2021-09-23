<?php
    echo $this->Form->create("addProductForm", array("url" => "#"));
    echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Product Name"));
    echo $this->Form->input("description", array("type" => "text", "label" => "", "placeholder" => "Product Description"));
    echo $this->Form->input("price", array("type" => "number", "label" => "", "placeholder" => "Product Price"));
    echo $this->Form->input("subCategoryId", array("type" => "text", "label" => "", "placeholder" => "Product Sub Category ID"));

    echo $this->Form->end("submit");
?>