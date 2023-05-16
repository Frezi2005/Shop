<?php

	echo $this->Html->css("form");
	echo $this->Html->script("change_password");

?>
<div id="main">
	<h1><?=__("change_password_form")?></h1>
	<div id="changePasswordForm">
		<?php
			echo $this->Form->create("changePasswordForm", array("url" => "/change-password"));
			echo $this->Form->input("currentPassword",
				array(
					"type" => "password",
					"label" => "",
					"placeholder" => __("current_password")
				)
			);
			echo $this->Form->input("newPassword",
				array(
					"type" => "password",
					"label" => "",
					"placeholder" => __("new_password")
				)
			);
			echo $this->Form->input("newPasswordConfirm",
				array(
					"type" => "password",
					"label" => "",
					"placeholder" => __("new_password_confirm")
				)
			);
			echo $this->Form->end(__("change"));
		?>
	</div>
</div>
<?php
if ($this->Session->read("userNotFoundError")) {
	echo "<script>Swal.fire({icon: \"error\",text: '" . __("user_with_password_not_found") . "',
			showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
	$_SESSION["userNotFoundError"] = false;
} else if ($this->Session->read("passwordMatchError")) {
	echo "<script>Swal.fire({icon: \"error\",text: '" . __("passwords_dont_match") .
		"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
	$_SESSION["passwordMatchError"] = false;
}
?>

