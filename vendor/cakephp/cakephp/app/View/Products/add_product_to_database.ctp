<?php
    echo $this->Form->create("addProductForm", array("url" => "#"));
    echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Product Name"));
    echo $this->Form->input("description", array("type" => "text", "label" => "", "placeholder" => "Product Description"));
    echo $this->Form->input("specs", array("type" => "text", "label" => "", "placeholder" => "Product Specification"));
    echo $this->Form->input("price", array("type" => "number", "label" => "", "placeholder" => "Product Price"));
    echo $this->Form->input("subCategoryId", array("options" => $subCategoriesIds));

    echo $this->Form->end("submit");
?>