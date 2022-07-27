<?php
echo $this->Html->css("remove_products");
?>
<div id="main">
	<div id="removeProductsForm">
		<?php
			echo $this->Form->create("removeProductsForm", array("url" => "/remove-products"));
			echo $this->Form->input("products", array("options" => $products, "multiple" => true));
			echo $this->Form->end(__("delete"));
		?>
	</div>
</div>
