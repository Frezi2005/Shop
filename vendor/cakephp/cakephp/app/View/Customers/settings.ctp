<h1>Change password</h1>
<h4><a href="home">Home Page</a></h4>
<div id="changePasswordForm">
    <?php
        echo $this->Form->create("changePasswordForm", array("url" => "/change-password"));
        echo $this->Form->input("currentPassword", array("type" => "password", "label" => "", "placeholder" => "Current password"));
        echo $this->Form->input("newPassword", array("type" => "password", "label" => "", "placeholder" => "New password"));
        echo $this->Form->input("newPasswordConfirm", array("type" => "password", "label" => "", "placeholder" => "New password confirm"));
        echo $this->Form->end("submit");
    ?>
</div>
