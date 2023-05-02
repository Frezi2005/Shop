<?php

App::uses("Component", "Controller");

class BudgetComponent extends Component {
	//Function responsible for returning budget by substracting expenses from incomes
	public function getBudgetIncome($year) {
		$budget = ClassRegistry::init('Budget');
		$amount = $budget->find("all",
			array(
				"conditions" => array(
					"year" => $year
				),
				"fields" => array(
					"type",
					"ROUND(SUM(amount), 2) as amount"
				),
				"group" => "type"
			)
		);
		$expenses = 0;
		$incomes = 0;
		for ($i = 0; $i < count($amount); $i++) {
			if ($amount[$i]["Budget"]["type"] == "exp") {
				$expenses = floatval($amount[$i][0]["amount"]);
			} else {
				$incomes = floatval($amount[$i][0]["amount"]);
			}
		}

		return $incomes - $expenses;
	}
}
