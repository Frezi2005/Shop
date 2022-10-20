<?php

    echo $this->Html->css("form");

?>
<div id="main">
    <h1><?=__("change_email_form")?></h1>
    <div id="changeEmailForm">
        <?php
            echo $this->Form->create("changeEmailForm", array("url" => "/send-change-email"));
            echo $this->Form->input("currentEmail", array("type" => "email", "label" => "", "placeholder" => __("enter_current_email"), "required" => "true", "value" => $email));
            echo $this->Form->input("newEmail", array("type" => "email", "label" => "", "placeholder" => __("enter_new_email"), "required" => "true", "value" => isset($_SESSION["data"]) && isset($_SESSION["data"]["newEmail"]) ? $_SESSION["data"]["newEmail"] : ""));
            echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => __("enter_password"), "required" => "true"));

            echo $this->Form->end(__("change"));
        ?>
    </div>
</div>
<?php
	if ($this->Session->read("changeEmailError")) {
		echo "<script>Swal.fire({icon: \"error\",text: '".__("change-email-error")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
		$_SESSION["changeEmailError"] = false;
	}
?>
