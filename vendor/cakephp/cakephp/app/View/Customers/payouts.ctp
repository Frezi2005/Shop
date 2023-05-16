<?php

	echo $this->Html->script("payouts");

	echo "<select id='year'>";
	for ($i = intval(date("Y")) - 5; $i <= intval(date("Y")) + 5; $i++) {
		echo '<option value="' . $i . '" ' . (date("Y") == $i ? 'selected="selected"' : '') . '>' . $i . "</option>";
	}
	echo "</select>";

	echo "<select id='month'>";
	for ($i = 1; $i <= 12; $i++) {
		$month = date("F", strtotime("2023-" . str_pad($i, 2, "0", STR_PAD_LEFT) . "-01"));
		echo '<option value="' . $i . '" ' . ($month == date("F") ? 'selected="selected"' : '') . '>' . $month . "</option>";
	}
	echo "</select>";

	foreach ($employees as $employee) {
//		$payed = $employee[0]["month"] == intval(date("m"));
//		echo "<p>{$employee["User"]["name"]}{$employee["User"]["surname"]} " .
//			($payed ? " - Zapłacone" : " - Do zapłaty") . "
//			<input type='checkbox' data-user-id='{$employee["User"]["id"]}' " . ($payed ? "disabled" : "") . "/></p>";
		debug($employee);
	}
	echo "<button id='pay'>" . __("payout") . "</button>";
?>
