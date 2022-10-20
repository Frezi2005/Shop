<?php

echo $this->Html->css("form");

?>
<div id="main">
	<h1><?=__("change_password_form")?></h1>
	<div id="changePasswordForm">
		<?php
			echo $this->Form->create("changePasswordForm", array("url" => "/change-password"));
			echo $this->Form->input("currentPassword", array("type" => "password", "label" => "", "placeholder" => __("current_password")));
			echo $this->Form->input("newPassword", array("type" => "password", "label" => "", "placeholder" => __("new_password")));
			echo $this->Form->input("newPasswordConfirm", array("type" => "password", "label" => "", "placeholder" => __("new_password_confirm")));
			echo $this->Form->end(__("change"));
		?>
	</div>
</div>
<?php
if ($this->Session->read("userNotFoundError")) {
	echo "<script>Swal.fire({icon: \"error\",text: 'User with that exact password has not been found in our database!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
	$_SESSION["userNotFoundError"] = false;
} else if ($this->Session->read("passwordMatchError")) {
	echo "<script>Swal.fire({icon: \"error\",text: 'Passwords don\'t match!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
	$_SESSION["passwordMatchError"] = false;
}
?>

