<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1>Change email</h1>
    <div id="changeEmailForm">
        <?php
            echo $this->Form->create("changeEmailForm", array("url" => "/send-change-email"));
            echo $this->Form->input("currentEmail", array("type" => "email", "label" => "", "placeholder" => "Enter your current email"));
            echo $this->Form->input("newEmail", array("type" => "email", "label" => "", "placeholder" => "Enter your new email"));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => "Enter your password"));

            echo $this->Form->end("submit");
        ?>
    </div>
</div>