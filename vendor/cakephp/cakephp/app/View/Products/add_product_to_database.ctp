<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1>Add products to database</h1>
    <div id="productsForm">
        <?php
            echo $this->Form->create("addProductForm", array("url" => "#", "enctype" => "multipart/form-data"));
            echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Product Name"));
            echo $this->Form->input("description", array("type" => "text", "label" => "", "placeholder" => "Product Description"));
            echo $this->Form->input("specs", array("type" => "text", "label" => "", "placeholder" => "Product Specification"));
            echo $this->Form->input("price", array("type" => "number", "label" => "", "placeholder" => "Product Price"));
            echo $this->Form->input("image", array("type" => "file", "label" => "Product image(Max size: 2MB, type: JPG)", "accept" => "image/jpeg"));
            echo $this->Form->input("subCategoryId", array("options" => $subCategoriesIds));

            echo $this->Form->end("submit");
        ?>
    </div>
</div>
<?php
if ($this->Session->read("sizeError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"Your file size exceedes the limit of 2MB!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["sizeError"] = false;
} else if ($this->Session->read("priceError") == true) {
    echo "<script>Swal.fire({icon: \"error\",text: \"Price value is invalid!\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
    $_SESSION["priceError"] = false;
}
?>