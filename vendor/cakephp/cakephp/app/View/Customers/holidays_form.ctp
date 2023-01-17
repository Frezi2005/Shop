<?php
    echo $this->Html->script("holidays_form");

    echo $this->Form->create("requestHolidaysForm", array("url" => "/request-holidays"));
    echo $this->Form->input("start", array("type" => "date", "label" => "", "dateFormat" => "YMD", "placeholder" => "start date"));
    echo $this->Form->input("end", array("type" => "date", "label" => "", "dateFormat" => "YMD", "placeholder" => "end date"));
    echo $this->Form->input("holidayType", array("options" => array(
        "occasional" => "Occasional leave",
        "on_request" => "Leave on request",
        "annual" => "Annual leave"
    )));
    echo $this->Form->end(__("submit"));
    echo "<p id='holidays'>Left <span>{$holidaysAmount}</span></p>";

    if ($this->Session->read("leaveRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: 'A leave request has been sent',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["leaveRequestSent"] = false;
    }
?>