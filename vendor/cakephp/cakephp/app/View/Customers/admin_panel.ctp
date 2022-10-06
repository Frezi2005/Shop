<?php

    echo $this->Html->script("admin_panel");
    echo $this->Html->css("admin_panel");

?>
<div id="main">
    <?php
        if($privileges["list-employees"]) {
            echo "<a href='list-employees' target='_blank'>".__("employees_list")."</a>";
        }

        if($privileges["inventory"]) {
            echo "<a href='inventory' target='_blank'>".__("products_list")."</a>";
        }

        if($privileges["remove-employee-page"]) {
            echo "<a href='remove-employee-page' target='_blank'>".__("remove_employee")."</a>";
        }

        if($privileges["orders-report"]) {
            echo "<a href='orders-report'>".__("orders_report")."</a>";
        }

        if($privileges["add-product-to-database"]) {
            echo "<a href='add-product-to-database'>".__("add_product_to_db")."</a>";
        }

        if($privileges["delivery-form"]) {
            echo "<a href='delivery-form'>".__("products_delivery")."</a>";
        }

        if($privileges["update-employee-page"]) {
            echo "<a href='update-employee-page'>".__("update_employee")."</a>";
        }

        if($privileges["admin-privileges"]) {
            echo "<select id='usersSelect'>";
            for ($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }
            echo "</select>";
            echo "<button id='grantAdmin'>".__("grant_admin")."</button>";
        }

        if($privileges["remove-customer"]) {
            echo "<select id='customersSelect'>";
            for ($i = 0; $i < count($customers); $i++) {
                echo "<option value='".$customers[$i]["User"]["id"]."'>".$customers[$i]["User"]["name"]." ".$customers[$i]["User"]["surname"].": ".$customers[$i]["User"]["email"]."</option>";
            }
            echo "</select>";
            echo "<button id='deleteCustomer'>".__("delete_customer")."</button>";
        }
    ?>

    <a href="monitor-employees-worktime">Monitorowanie godzin pracy pracowników</a>

</div>
