<?php
    echo $this->Form->create("requestSickLeaveForm", array("url" => "/request-sick-leave"));
    echo $this->Form->input("start", array("type" => "date", "label" => "", "dateFormat" => "YMD", "placeholder" => "start date"));
    echo $this->Form->input("end", array("type" => "date", "label" => "", "dateFormat" => "YMD", "placeholder" => "end date"));
    echo $this->Form->end(__("submit"));

    if ($this->Session->read("sickLeaveRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: 'A sick leave request has been sent',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["sickLeaveRequestSent"] = false;
    }
?>