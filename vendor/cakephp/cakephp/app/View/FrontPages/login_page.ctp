<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1>Login page</h1>
    <div id="loginForm">
        <?php
            echo $this->Form->create("loginUserForm", array("url" => "/login-customer"));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email input"));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => "Password input"));
            echo $this->Form->end("submit");
        ?>
    </div>
</div>

