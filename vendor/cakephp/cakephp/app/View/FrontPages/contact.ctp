<?php

    echo $this->Html->script("contact_validation");
    echo $this->Html->css("contact");
    echo $this->Html->css("registerAndLogin");
    
?>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<div id="contactForm">
    <h1>Contact</h1>
    <?php

        echo $this->Form->create("contactForm", array("url" => "/send-email-from-customer"));
        echo $this->Form->input("messageType", array("options" => array("Opinion" => "Opinion", "Complaint" => "Complaint", "Cooperative offer" => "Cooperative offer", "Media contact" => "Media contact", "Other" => "Other")));
        if (!$_SESSION["loggedIn"]) {
            echo $this->Form->input("from", array("type" => "email", "label" => false, "placeholder" => "From"));
        }
        echo $this->Form->input("message", array("type" => "textarea", "label" => false, "placeholder" => "message"));
        echo "<div class='g-recaptcha' data-sitekey='6LfVFXUfAAAAAElmtQKXvt_3HFLJvNE2Mi4UR3IY'></div>";
        echo $this->Form->end("send");

        if ($this->Session->read("contactEmailSent") === true) {
            echo "<script>Swal.fire({icon: \"success\",text: \"Your message has been sent. We'll reply in 2-3 work days.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
            $_SESSION["contactEmailSent"] = null;
        } else if ($this->Session->read("contactEmailSent") === false) {
            echo "<script>Swal.fire({icon: \"error\",text: \"Your message couldn't be sent. Try again later.\",showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
            $_SESSION["contactEmailSent"] = null;
        }
    ?>
    <span id="emailError"></span>
    <span id="messageError"></span>
</div>