<?php
echo $this->Html->css("update_image");
?>
<div id="main">
	<div id="updateImageForm">
		<?php
			echo $this->Form->create("updateProductForm", array("url" => "/update-image", "enctype" => "multipart/form-data"));
			echo $this->Form->input("id", array("type" => "text", "label" => "", "placeholder" => __("product_id")));
			echo $this->Form->input("image", array("type" => "file", "label" => __("image"), "accept" => "image/jpeg"));
			echo $this->Form->end(__("update"));
		?>
	</div>
</div>
