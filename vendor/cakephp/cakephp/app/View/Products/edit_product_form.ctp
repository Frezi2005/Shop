<?php
    echo $this->Html->script("edit_product");
	echo $this->Html->css("edit_product");
?>
<div id="main">
	<div id="editProductForm">
		<select id='productSelect'>
			<?php
				for($i = 0; $i < count($products); $i++) {
					$products[$i]["Products"]["description"] = htmlentities($products[$i]["Products"]["description"], ENT_QUOTES);
					echo "<option value='".$products[$i]["Products"]["id"]."' data-product='".json_encode($products[$i]["Products"])."'>".$products[$i]["Products"]["name"]."</option>";
				}
			?>
		</select>
		<div id="inputs"></div>
	</div>
</div>
