<?php

    echo $this->Html->script("admin_panel");
    echo $this->Html->css("admin_panel");

?>
<div id="main">
    <a href="list-employees" target="_blank">Employees list</a>
    <a href="inventory" target="_blank">Products List</a>
    <a href="remove-employee-page" target="_blank">Remove employee</a>
    <a href="orders-report">Orders report</a>
    <a href="add-product-to-database">Add product to DB</a>
    <a href="delivery-form">Products delivery</a>
    <a href="update-employee-page">Update employee</a>
    <select id="usersSelect">
        <?php
            for ($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }   
        ?>
    </select>
    <button id="grantAdmin">Grant admin privileges</button>
    <select id="customersSelect">
        <?php
            for ($i = 0; $i < count($customers); $i++) {
                echo "<option value='".$customers[$i]["User"]["id"]."'>".$customers[$i]["User"]["name"]." ".$customers[$i]["User"]["surname"].": ".$customers[$i]["User"]["email"]."</option>";
            }   
        ?>
    </select>
    <button id="deleteCustomer">Delete customer</button>
    <?php
        if ($privileges["ksiegowosc"]) {
            echo "<a href='ksiegowosc'>Księgowość</a>";
        }

        if ($privileges["kadry"]) {
            echo "<a href='kadry'>Kadry</a>";
        }

        if ($privileges["kierownictwo"]) {
            echo "<a href='kierownictwo'>Kierownictwo</a>";
        }

        if ($privileges["pracownicy"]) {
            echo "<a href='pracownicy'>Pracownicy szeregowi</a>";
        }
    ?>
</div>