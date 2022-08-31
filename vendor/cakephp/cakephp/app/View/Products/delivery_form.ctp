<?php
    echo $this->Html->script("delivery_form");
	echo $this->Html->css("delivery_form");
?>
<div id="main">
	<div id="deliveryForm">
		<?php
			echo $this->Form->create("deliveryForm", array("url" => "/add-products-from-delivery"));
			echo $this->Form->input("products", array("options" => $products, "multiple" => true, "label" => __("products"), "size" => 10));
			echo $this->Form->input("count", array("type" => "number", "label" => "", "placeholder" => __("number_of_products")));
			echo $this->Form->end(__("submit"));
		?>
	</div>
</div>
<?php
    if ($this->Session->read("numberError") == true) {
        echo "<script>Swal.fire({icon: \"error\",text: ".__("number_error").",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["numberError"] = false;
    }
?>
