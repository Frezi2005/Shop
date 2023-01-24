<?php
    echo $this->Form->create("requestSickLeaveForm", array("url" => "/request-sick-leave"));
    echo $this->Form->input("start", array("type" => "date", "label" => "", "dateFormat" => "YMD", "label" => __("sick_leave_start_date")));
    echo $this->Form->input("end", array("type" => "date", "label" => "", "dateFormat" => "YMD", "label" => __("sick_leave_end_date")));
    echo $this->Form->end(__("submit"));

    if ($this->Session->read("sickLeaveRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: '".__("sick_leave_request_sent")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["sickLeaveRequestSent"] = false;
    }
?>