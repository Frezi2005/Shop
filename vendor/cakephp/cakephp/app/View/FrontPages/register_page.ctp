<?php 
    echo $this->Html->script("register");
    echo $this->Html->css("form");
?>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<div id="main">
    <h1>Register page</h1>
    <div id="registerForm">
        <?php
            echo $this->Form->create("registerUserForm", array("url" => "/register-customer"));
            echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => "Name"));
            echo $this->Form->input("surname", array("type" => "text", "label" => "", "placeholder" => "Surname"));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email"));
            echo $this->Form->input("phoneNumber", array("type" => "text", "label" => "", "placeholder" => "Phone number"));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => "Password"));
            echo $this->Form->input("passwordConfirm", array("type" => "password", "label" => "", "placeholder" => "Confirm password"));
            echo $this->Form->input("birthDate", array("type" => "text", "label" => "", "placeholder" => "Format: YYYY-MM-DD"));
            echo "<div class='g-recaptcha' data-sitekey='6LfVFXUfAAAAAElmtQKXvt_3HFLJvNE2Mi4UR3IY'></div>";
            echo $this->Form->input("rules", array("type" => "checkbox", "label" => "I accept the <a href=\"rules\" target=\"_blank\">terms of service</a>", "required" => true));
            echo $this->Form->end("submit");
        ?>
    </div>
</div>
