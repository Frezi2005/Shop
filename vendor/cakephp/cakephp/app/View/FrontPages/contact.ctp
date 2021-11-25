<?=$this->Html->script("contact_validation");?>
<h1>Contact</h1>
<?php

    echo $this->Form->create("contactForm", array("url" => "/send-email-from-customer"));
    echo $this->Form->input("messageType", array("options" => array("Opinion" => "Opinion", "Complaint" => "Complaint", "Cooperative offer" => "Cooperative offer", "Media contact" => "Media contact", "Other" => "Other")));
    echo $this->Form->input("from", array("type" => "email", "label" => false, "placeholder" => "From"));
    echo $this->Form->input("message", array("type" => "textarea", "label" => false, "placeholder" => "message"));
    echo $this->Form->end("send");

    if ($this->Session->read("contactEmailSent") === true) {
        echo "<script>Swal.fire({icon: \"success\",text: \"Your message has been sent. We'll reply in 2-3 work days.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["contactEmailSent"] = null;
    } else if($this->Session->read("contactEmailSent") === false) {
        echo "<script>Swal.fire({icon: \"error\",text: \"Your message couldn't be sent. Try again later.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["contactEmailSent"] = null;
    }
?>
<span id="emailError"></span>
<span id="messageError"></span>
