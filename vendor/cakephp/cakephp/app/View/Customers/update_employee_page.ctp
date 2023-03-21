<?php
    echo $this->Html->script("update_employee");
	echo $this->Html->css("update_employee");
?>
<div id="main">
	<div id="updateEmployeeForm">
		<select id='employeesSelect'>
			<?php
				for ($i = 0; $i < count($employees); $i++) {
					echo "<option value='".$employees[$i]["User"]["id"]."' data-employee='".json_encode($employees[$i]["User"])."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
				}
			?>
		</select>
		<div id="inputs"></div>
	</div>
</div>
