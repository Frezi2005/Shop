<?php

    echo $this->Form->create("updatePasswordForm", array("url" => "/update-password"));
    echo $this->Form->input("password", array("type" => "password", "label" => "", "placeholder" => __("password")));
    echo $this->Form->input("passwordConfirm", array(
		"type" => "password",
		"label" => "",
		"placeholder" => __("password_confirm")
	));
    echo $this->Form->input("id", array("type" => "hidden", "value" => $id));
    echo $this->Form->end(__("update"));

?>
