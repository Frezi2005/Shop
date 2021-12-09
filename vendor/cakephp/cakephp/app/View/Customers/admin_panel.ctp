<?php

    echo $this->Html->script("admin_panel");

?>
<ul>
    <li><a href="list-employees" target="_blank">Employees list</a></li>
    <li><a href="inventory" target="_blank">Products List</a></li>
    <select id="usersSelect">
        <?php
            for($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }   
        ?>
    </select>
    <button id="grantAdmin">Grant admin privileges</button>
</ul>