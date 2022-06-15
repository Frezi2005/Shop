<?php 

    echo $this->Html->css("form");
    echo $this->Html->css("settings");
    echo $this->Html->script("settings");

?>
<div id="main">
    <p><a href="change-email-form">Change email</a></p>
    <p><a href="">Change password</a></p>
    <p><a href="change-address-form">Change address</a></p>
    <?php 
        if ($is_admin) {
            echo "<a href=\"admin-panel\">Admin Panel</a>";
        } else {
            echo "<p><a href=\"\" id=\"delAccount\">Delete account</a></p>";
        }
    ?>
    <!-- <a href="error-test">error test</a> -->
    <!-- <h1>Change password</h1>
    <div id="changePasswordForm">
        <?php
            // echo $this->Form->create("changePasswordForm", array("url" => "/change-password"));
            // echo $this->Form->input("currentPassword", array("type" => "password", "label" => "", "placeholder" => "Current password"));
            // echo $this->Form->input("newPassword", array("type" => "password", "label" => "", "placeholder" => "New password"));
            // echo $this->Form->input("newPasswordConfirm", array("type" => "password", "label" => "", "placeholder" => "New password confirm"));
            // echo $this->Form->end("submit");
        ?>
    </div> -->
</div>

