<?php
    echo $this->Html->script("delivery_form");
	echo $this->Html->css("delivery_form");
?>
<div id="main" class="col-12">
	<div id="deliveryForm" class="offset-1 col-10">
		<?php
			echo $this->Form->create("deliveryForm", array("url" => "/add-products-from-delivery"));
			echo $this->Form->input("products",
				array(
					"options" => $products,
					"multiple" => true,
					"label" => __("products"),
					"size" => 10
				)
			);
			echo $this->Form->input("count",
				array(
					"type" => "number",
					"label" => "",
					"placeholder" => __("number_of_products")
				)
			);
			echo $this->Form->end(__("add"));
		?>
	</div>
</div>
<?php
    if ($this->Session->read("numberError") == true) {
        echo "<script>Swal.fire({icon: \"error\",text: '".__("number_error").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["numberError"] = false;
    } else if ($this->Session->read("productsAdded") == true) {
		echo "<script>Swal.fire({icon: \"success\",text: '".__("products_added").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["productsAdded"] = false;
	} else if ($this->Session->read("notEnoughFunds") == true) {
		echo "<script>Swal.fire({icon: \"error\",text: '".__("not_enough_funds").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["productsAdded"] = false;
	}
?>
