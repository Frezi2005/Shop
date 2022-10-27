<?php 
    echo $this->Html->script("register");
    echo $this->Html->css("form");
    echo $this->Html->css("registerAndLogin");
?>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<div id="main" class="registerForm">
    <h1><?=__("registration_form")?></h1>
    <div id="registerForm">
        <?php
            echo $this->Form->create("registerUserForm", array("url" => "/register-customer"));
            echo $this->Form->input("name", array("type" => "text", "label" => "", "placeholder" => __("name")));
            echo $this->Form->input("surname", array("type" => "text", "label" => "", "placeholder" => __("surname")));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => __("email")));
            echo $this->Form->input("phoneNumber", array("type" => "text", "label" => "", "placeholder" => __("phone_number")));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => __("password")));
            echo $this->Form->input("passwordConfirm", array("type" => "password", "label" => "", "placeholder" => __("password_confirm")));
            // echo $this->Form->input("birthDate", array("type" => "date", "label" => "", "placeholder" => __("birth_date"), "max" => date("Y-m-d")));
            echo "<div class='input date'><label for='registerUserFormBirthDate'></label><input name='data[registerUserForm][birthDate]' placeholder='".__("birth_date")."' type='date' id='registerUserFormBirthDate' max='".date('Y-m-d', strtotime('-18 year'))."'></div>";
            echo "<div class='g-recaptcha' data-sitekey='6LfVFXUfAAAAAElmtQKXvt_3HFLJvNE2Mi4UR3IY'></div>";
            echo $this->Form->input("rules", array("type" => "checkbox", "label" => __("tos"), "style" => "height: 50px; aspect-ratio: 1;"));
            echo $this->Form->end(__("register"));
        ?>
    </div>
</div>
