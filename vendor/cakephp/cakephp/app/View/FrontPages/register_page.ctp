<?php 
    echo $this->Html->script("register");
?>
<h1>Register page</h1>
<h4><a href="home">Home Page</a></h4>
<div id="registerForm">
    <?php
        echo $this->Form->create("registerUserForm", array("url" => "#"));
        echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Name input"));
        echo $this->Form->input("surname", array("type" => "text", "label" => "", "placeholder" => "Surname input"));
        echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email input"));
        echo $this->Form->input("phoneNumber", array("type" => "text", "label" => "", "placeholder" => "Phone number input"));
        echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => "Password input"));
        echo $this->Form->input("passwordConfirm", array("type" => "password", "label" => "", "placeholder" => "Confirm password input"));
        echo $this->Form->input("birthDate", array("type" => "text", "label" => "", "placeholder" => "Format: DD/MM/YYYY"));

        echo $this->Form->end("submit");
    ?>
</div>
