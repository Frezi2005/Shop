<?php

    echo $this->Form->create("fireEmployeeForm", array("url" => "/send-notice-request"));
    echo $this->Form->input("employees", array("options" => $employees, "required" => true, "label" => __("employees")));
    echo $this->Form->input("noticeType", array("options" => array(
        "notice" => __("notice"),
        "mutual_consent" => __("notice_by_consent")
    ), "label" => __("notice_type")));
    echo $this->Form->input("userId", array("type" => "hidden", "value" => $_SESSION["userUUID"]));
    echo $this->Form->end(__("fire"));

    if ($this->Session->read("noticeExistsError")) {
        echo "<script>Swal.fire({icon: 'error',text: '".__("employee_already_fire").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["noticeExistsError"] = false;
    }

?>
