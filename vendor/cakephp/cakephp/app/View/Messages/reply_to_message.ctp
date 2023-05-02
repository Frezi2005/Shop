<?php

    echo "<p>".ucfirst(__("message")).": ".$message."</p>";
    echo $this->Form->create("replyForm", array("url" => "/send-reply-to-user"));
    echo $this->Form->input("message",
		array(
			"type" => "textarea",
			"label" => false,
			"placeholder" => __("your_message")
		)
	);
    echo $this->Form->hidden("id", array("value" => $id));
    echo $this->Form->hidden("email", array("value" => $email));
    echo $this->Form->end(__("send"));
?>
