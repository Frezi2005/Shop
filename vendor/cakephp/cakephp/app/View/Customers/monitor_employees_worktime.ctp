<?php

	echo "<h3>" . date("F Y") . "</h3>";
    foreach ($employees as $employee) {
		$hours = intval($employee[0]["hours"] / 60 / 60);
		$minutes = ($employee[0]["hours"] - $hours * 3600) / 60;
		echo "<p>{$employee["User"]["name"]} {$employee["User"]["surname"]} - <b>{$hours}h {$minutes}m</b></p>";
    }

?>
