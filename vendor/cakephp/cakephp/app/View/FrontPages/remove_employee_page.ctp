<?php
	echo $this->Html->css("remove_employee")
?>
<div id="main">
	<div id="removeEmployeesForm">
		<?php
			echo $this->Form->create("removeEmployeesForm", array("url" => "/remove-employee"));
			echo $this->Form->input("employees", array("options" => $employees, "label" => __("employees")));
			echo $this->Form->end(__("delete"));
		?>
	</div>
</div>
