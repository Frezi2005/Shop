<?php
	echo $this->Html->script("monitor_employees_worktime");
	echo $this->Html->css("monitor_employees_worktime");

	echo "<div class='float-start offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 my-3'>";
	echo "<h3 id='date'>" . date("F Y") . "</h3>";
	echo "<input type='hidden' id='lang' value='" . $_SESSION["language"] . "'/>";
	echo "<select id='year'>";
	for ($i = date("Y") - 5; $i <= date("Y") + 5; $i++) {
		echo '<option value="' . $i . '" ' . (date("Y") == $i ? 'selected="selected"' : '') . '>' . $i . "</option>";
	}
	echo "</select>";
	echo "<select id='month'>";
	for ($i = 1; $i <= 12; $i++) {
		$month = date("F", strtotime("2023-" . ($i < 10 ? '0'.$i : $i) . "-01"));
		echo '<option value="' . $i . '" ' . ($month == date("F") ? 'selected="selected"' : '') . '>' . $month . "</option>";
	}
	echo "</select>";
	echo "<input type='hidden' id='employees' value='" . json_encode($employees) . "'/>";
	echo "<div id='timeshifts'></div>";
	echo "<div id='timeshifts'></div>";
	echo "<div class='pagination'></div>";
	echo "</div>";

?>
