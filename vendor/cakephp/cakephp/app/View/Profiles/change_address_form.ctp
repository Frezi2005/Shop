<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1><?=__("change_address_form")?></h1>
    <div id="changeAddressForm">
        <?php
            echo $this->Form->create("changeAddressForm", array("url" => "/change-address"));
            echo $this->Form->input("country",
				array(
					"options" => $countries,
					"label" => __("country"),
					"required" => true
				)
			);
            echo $this->Form->input("city",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("city"),
					"pattern" => "[a-zA-Z\s]+",
					"required" => true
				)
			);
            echo $this->Form->input("street",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("street"),
					"pattern" => "[\da-zA-Z\s]+",
					"required" => true
				)
			);
            echo $this->Form->input("house_number",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("house_number"),
					"pattern" => "(([1-9])([0-9]*)[a-z]|([1-9])([0-9]*))",
					"required" => true
				)
			);
            echo $this->Form->input("flat_number",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("flat_number"),
					"pattern" => "([1-9])([0-9]*)",
					"required" => true
				)
			);

            echo $this->Form->end(__("change"));
        ?>
    </div>
</div>
<?php
if ($this->Session->read("changeAddressError")) {
	echo "<script>Swal.fire({icon: \"error\",text: '".__("change-address-error").
		"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
	$_SESSION["changeAddressError"] = false;
}
?>
