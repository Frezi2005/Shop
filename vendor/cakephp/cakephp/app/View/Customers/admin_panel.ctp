<?php

    echo $this->Html->script("admin_panel");
    echo $this->Html->css("admin_panel");

?>
<div id="main">
    <?php
        echo "<div class='col'>";
        if ($privileges["list-employees"]) {
            echo "<a href='list-employees'>".__("employees_list")."</a>";
        }

        if ($privileges["inventory"]) {
            echo "<a href='inventory'>".__("products_list")."</a>";
        }

        if ($privileges["remove-employee-page"]) {
            echo "<a href='remove-employee-page'>".__("remove_employee")."</a>";
        }

        if ($privileges["orders-report"]) {
            echo "<a href='orders-report'>".__("orders_report")."</a>";
        }

        if ($privileges["add-product-to-database"]) {
            echo "<a href='add-product-to-database'>".__("add_product_to_db")."</a>";
        }

        if ($privileges["delivery-form"]) {
            echo "<a href='delivery-form'>".__("products_delivery")."</a>";
        }

        if ($privileges["update-employee-page"]) {
            echo "<a href='update-employee-page'>".__("update_employee")."</a>";
        }

        if ($privileges["holidays-approval-form"]) {
            echo "<a href='holidays-approval-form'>".__("holidays_approval_form")."</a>";
        }

        echo "<a href='invoices'>".__("invoices")."</a>";
        echo "<a href='view-messages'>".__("view_messages")."</a>";

        echo "</div>";
        echo "<div class='col'>";
        
        if ($privileges["admin-privileges"] && count($employees) > 0) {
            echo "<select id='usersSelect'>";
            for ($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }
            echo "</select>";
            echo "<button id='grantAdmin'>".__("grant_admin")."</button>";
        }

        if ($privileges["remove-customer"] && count($customers) > 0) {
            echo "<select id='customersSelect'>";
            for ($i = 0; $i < count($customers); $i++) {
                echo "<option value='".$customers[$i]["User"]["id"]."'>".$customers[$i]["User"]["name"]." ".$customers[$i]["User"]["surname"].": ".$customers[$i]["User"]["email"]."</option>";
            }
            echo "</select>";
            echo "<button id='deleteCustomer'>".__("delete_customer")."</button>";
        }
    ?>

        <a href="monitor-employees-worktime"><?=__("monitoring_hours");?></a>
        <a href="fire-employee-form"><?=__("fire_employees");?></a>
        <a href="extend-contract-request-form"><?=__("extend_contract");?></a>
        <a href="view-contract-extension-requests"><?=__("view_contract_extensions_requests");?></a>
        <a href="manage-budget"><?=__("manage_budget");?></a>
        <a href="work-hours"><?=__("work_hours");?></a>
    </div>
</div>
