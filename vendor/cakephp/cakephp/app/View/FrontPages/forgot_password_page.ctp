<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<?php

	echo $this->Html->script("forgot_password");
	echo $this->Html->css("forgot_password");

?>
<div id="main">
	<h1><?=__("forgot_password_form")?></h1>
	<div id="forgotPasswordForm">
		<?php
			echo $this->Form->create("forgotPasswordForm", array("url" => "/send-forgot-password-email"));
			echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => "Email"));
			echo "<div class='g-recaptcha' data-sitekey='6LfVFXUfAAAAAElmtQKXvt_3HFLJvNE2Mi4UR3IY'></div>";
			echo $this->Form->end(__("send"));
		?>
	</div>
</div>
<?php
    if ($this->Session->read("userNotFound")) {
        echo "<script>Swal.fire({icon: \"error\",text: '".__("user_not_found").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["userNotFound"] = false;
    }
?>
