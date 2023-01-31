<?php

    foreach ($messages as $message) {
        echo "<p>".$message["Message"]["email"]."(".__(strtolower(str_replace(" ", "_", $message["Message"]["type"])))."):<br/>".$message["Message"]["message"]."<br/><a href='reply-to-message?id=".$message["Message"]["id"]."'>".__("reply")."</a></p>";
    }

    if ($this->Session->read("messageSent") == true) {
        echo "<script>Swal.fire({icon: \"success\",text: '".__("message_sent_successfully")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["messageSent"] = null;
    } else if ($this->Session->read("messageSent") === false) {
        echo "<script>Swal.fire({icon: \"error\",text: '".__("message_sent_unsuccessfully")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["messageSent"] = null;
    }

?>