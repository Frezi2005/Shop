<?php
    echo $this->Form->create("noticeRequestForm", array("url" => "/send-notice-request"));
    echo $this->Form->input("noticeType", array("options" => array(
        "notice" => __("notice"),
        "mutual_consent" => __("notice_by_consent")
    ), "label" => __("notice_type")));
    echo $this->Form->end(__("submit"));

    if ($this->Session->read("noticeRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: '".__("notice_request_sent").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeRequestSent"] = false;
    } else if ($this->Session->read("noticeExistsError")) {
        echo "<script>Swal.fire({icon: 'error',text: '".__("notice_request_exsits").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeExistsError"] = false;
    }
?>
