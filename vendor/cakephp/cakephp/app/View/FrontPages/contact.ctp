<?php

    echo $this->Html->script("contact_validation");
    echo $this->Html->css("contact");
    echo $this->Html->css("registerAndLogin");

?>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<div id="contactForm">
    <h1><?=__("contact")?></h1>
    <?php

        echo $this->Form->create("contactForm", array("url" => "/send-email-from-customer"));
        echo $this->Form->input("messageType", array("options" => array("Opinion" => __("opinion"), "Complaint" => __("complaint"), "Cooperative offer" => __("cooperative_offer"), "Media contact" => __("media_contact"), "Other" => __("other")), "label" => __("message_type")));
        if (!isset($_SESSION["loggedIn"])) {
            echo $this->Form->input("from", array("type" => "email", "label" => false, "placeholder" => __("from")));
        }
        echo $this->Form->input("message", array("type" => "textarea", "label" => false, "placeholder" => __("message"), "value" => isset($template) ? $template : ""));
        echo "<div class='g-recaptcha' data-sitekey='6LfVFXUfAAAAAElmtQKXvt_3HFLJvNE2Mi4UR3IY'></div>";
        echo $this->Form->end(__("send"));
    ?>
</div>
