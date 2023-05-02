<?php
    echo $this->Html->script("holidays_form");

    echo $this->Form->create("requestHolidaysForm", array("url" => "/request-holidays"));
    echo $this->Form->input("start", array(
		"type" => "date",
		"label" => "",
		"dateFormat" => "YMD",
		"label" => __("holiday_start_date")
	));
    echo $this->Form->input("end", array(
		"type" => "date",
		"label" => "",
		"dateFormat" => "YMD",
		"label" => __("holiday_end_date")
	));
    echo $this->Form->input("holidayType", array("options" => array(
        "occasional" => __("occasional_leave"),
        "on_request" => __("leave_on_request"),
        "annual" => __("annual_leave")
    ), "label" => __("holiday_type")));
    echo $this->Form->end(__("submit"));
    echo "<p id='holidays'>".__("left")." <span>{$holidaysAmount}</span></p>";

    if ($this->Session->read("leaveRequestSent")) {
        echo "<script>Swal.fire({icon: 'success',text: '".__("leave_request_sent").
			"',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["leaveRequestSent"] = false;
    }
?>
