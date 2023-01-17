<?php

    echo $this->Form->create("fireEmployeeForm", array("url" => "/send-notice-request"));
    echo $this->Form->input("employees", array("options" => $employees, "required" => true));
    echo $this->Form->input("noticeType", array("options" => array(
        "notice" => "Notice",
        "mutual_consent" => "Notice by mutual consent"
    )));
    echo $this->Form->input("userId", array("type" => "hidden", "value" => $_SESSION["userUUID"]));
    echo $this->Form->end("Fire");

    if ($this->Session->read("noticeExistsError")) {
        echo "<script>Swal.fire({icon: 'error',text: 'You have already fired this employee!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeExistsError"] = false;
    }

?>