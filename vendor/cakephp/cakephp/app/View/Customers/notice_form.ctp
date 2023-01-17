<?php
    echo $this->Form->create("noticeRequestForm", array("url" => "/send-notice-request"));
    echo $this->Form->input("noticeType", array("options" => array(
        "notice" => "Notice",
        "mutual_consent" => "Notice by mutual consent"
    )));
    echo $this->Form->end(__("submit"));

    if ($this->Session->read("noticeRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: 'A notice request has been sent',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeRequestSent"] = false;
    } else if ($this->Session->read("noticeExistsError")) {
        echo "<script>Swal.fire({icon: 'error',text: 'You have already requested a notice!',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeExistsError"] = false;
    }
?>