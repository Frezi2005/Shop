<?php

    echo $this->Html->script("admin_panel");
    echo $this->Html->css("admin_panel");

?>
<div id="main">
    <a href="list-employees" target="_blank">Employees list</a>
    <a href="inventory" target="_blank">Products List</a>
    <a href="remove-employee-page" target="_blank">Remove employee</a>
    <a href="orders-report">Orders report</a>
    <select id="usersSelect">
        <?php
            for($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }   
        ?>
    </select>
    <button id="grantAdmin">Grant admin privileges</button>
</div>