<?php

    echo $this->Html->script("update_employee");

    echo "<select id='employeesSelect'>";
    for($i = 0; $i < count($employees); $i++) {
        echo "<option value='".$employees[$i]["User"]["id"]."' data-employee='".json_encode($employees[$i]["User"])."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
    }
    echo "</select>";

?>
<div id="inputs"></div>