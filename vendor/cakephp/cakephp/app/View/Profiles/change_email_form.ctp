<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1><?=__("change_email_form")?></h1>
    <div id="changeEmailForm">
        <?php
            echo $this->Form->create("changeEmailForm", array("url" => "/send-change-email"));
            echo $this->Form->input("currentEmail", array("type" => "email", "label" => "", "placeholder" => __("enter_current_email")));
            echo $this->Form->input("newEmail", array("type" => "email", "label" => "", "placeholder" => __("enter_new_email")));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => __("enter_password")));

            echo $this->Form->end(__("submit"));
        ?>
    </div>
</div>
