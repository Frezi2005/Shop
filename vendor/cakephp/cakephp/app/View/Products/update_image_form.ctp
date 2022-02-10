<?php
    echo $this->Form->create("updateProductForm", array("url" => "/update-image", "enctype" => "multipart/form-data"));  
    echo $this->Form->input("id", array("type" => "text", "label" => "", "placeholder" => "Product id"));  
    echo $this->Form->input("image", array("type" => "file", "label" => "Product image(Max size: 2MB, type: JPG)", "accept" => "image/jpeg"));
    echo $this->Form->end("update");
?>