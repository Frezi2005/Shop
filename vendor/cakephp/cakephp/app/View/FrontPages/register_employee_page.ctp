<?php

    echo $this->Html->script("register_employee");
    echo $this->Html->css("form");

?>
<div id="main">
    <h1>Register employees page</h1>
    <div id="registerForm">
        <?php
            echo $this->Form->create("registerEmployeeForm", array("url" => "/register-employee"));
            echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Name"));
            echo $this->Form->input("surname", array("type" => "text", "label" => "", "placeholder" => "Surname"));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email"));
            echo $this->Form->input("phoneNumber", array("type" => "text", "label" => "", "placeholder" => "Phone number"));
            echo $this->Form->input("birthDate", array("type" => "text", "label" => "", "placeholder" => "Format: YYYY-MM-DD"));
            echo $this->Form->input("country", array("type" => "text", "label" => "", "placeholder" => "Country"));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => "City"));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => "Street"));
            echo $this->Form->input("houseNumber", array("type" => "text", "label" => "", "placeholder" => "House number"));
            echo $this->Form->input("flatNumber", array("type" => "text", "label" => "", "placeholder" => "Flat number"));
            echo $this->Form->input("idNumberAndSeries", array("type" => "text", "label" => "", "placeholder" => "Id"));
            echo $this->Form->input("salary", array("type" => "text", "label" => "", "placeholder" => "Salary"));
            echo $this->Form->input("internshipLength", array("type" => "text", "label" => "", "placeholder" => "Internship length"));
            echo $this->Form->input("bonusAmount", array("type" => "text", "label" => "", "placeholder" => "Bonus amount"));
            echo $this->Form->input("holidayAmount", array("type" => "text", "label" => "", "placeholder" => "Holiday amount"));
            echo $this->Form->end("submit");
        ?>
    </div>
</div>
