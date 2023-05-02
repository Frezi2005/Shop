<?php

    echo $this->Html->script("register_employee");
    echo $this->Html->css("form");

?>
<div id="main">
    <h1><?=__("employees_registration_form")?></h1>
    <div id="registerForm">
        <?php
            echo $this->Form->create("registerEmployeeForm", array("url" => "/register-employee"));
            echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => __("name")));
            echo $this->Form->input("surname", array("type" => "text", "label" => "", "placeholder" => __("surname")));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => __("email")));
            echo $this->Form->input("phoneNumber",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("phone_number")
				)
			);
            echo $this->Form->input("birthDate",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("date_format")
				)
			);
            echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => __("country")));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => __("city")));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => __("street")));
            echo $this->Form->input("houseNumber",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("house_number")
				)
			);
            echo $this->Form->input("flatNumber",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("flat_number")
				)
			);
            echo $this->Form->input("idNumberAndSeries",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("id")
				)
			);
            echo $this->Form->input("salary", array("type" => "text", "label" => "", "placeholder" => __("salary")));
            echo $this->Form->input("internshipLength",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("internship_length")
				)
			);
            echo $this->Form->input("bonusAmount",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("bonus_amount")
				)
			);
            echo $this->Form->input("holidayAmount",
				array(
					"type" => "text",
					"label" => "",
					"placeholder" => __("holiday_amount")
				)
			);
            echo $this->Form->end(__("register"));
        ?>
    </div>
</div>
