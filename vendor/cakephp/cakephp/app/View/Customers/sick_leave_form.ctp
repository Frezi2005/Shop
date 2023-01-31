<?php

    echo $this->Html->script("sick_leave_form");

    echo $this->Form->create("requestSickLeaveForm", array("url" => "/request-sick-leave"));
    echo "<div class='input date'>";
    echo "<label for='data[requestSickLeaveForm][start]'>".__("sick_leave_start_date")."</label>";
    echo "<input type='date' name='data[requestSickLeaveForm][start]' min='".date("Y-m-d")."'>";
    echo "</div>";
    echo "<div class='input date'>";
    echo "<label for='data[requestSickLeaveForm][end]'>".__("sick_leave_end_date")."</label>";
    echo "<input type='date' name='data[requestSickLeaveForm][end]' min='".date("Y-m-d")."'>";
    echo "</div>";
    echo $this->Form->end(__("submit"));

    if ($this->Session->read("sickLeaveRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: '".__("sick_leave_request_sent")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["sickLeaveRequestSent"] = false;
    } else if ($this->Session->read("sickLeaveDatesTooMuchDifference")) {
        echo "<script>Swal.fire({icon: 'error',text: '".__("sick_leave_too_long")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["sickLeaveDatesTooMuchDifference"] = false;
    }
?>