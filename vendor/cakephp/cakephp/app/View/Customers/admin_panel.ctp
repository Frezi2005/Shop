<?php

    echo $this->Html->script("admin_panel");
    echo $this->Html->css("admin_panel");

?>
<div id="main">
    <a href="list-employees" target="_blank"><?=__("employees_list")?></a>
    <a href="inventory" target="_blank"><?=__("products_list")?></a>
    <a href="remove-employee-page" target="_blank"><?=__("remove_employee")?></a>
    <a href="orders-report"><?=__("orders_report")?></a>
    <a href="add-product-to-database"><?=__("add_product_to_db")?></a>
    <a href="delivery-form"><?=__("products_delivery")?></a>
    <a href="update-employee-page"><?=__("update_employee")?></a>
    <select id="usersSelect">
        <?php
            for ($i = 0; $i < count($employees); $i++) {
                echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
            }
        ?>
    </select>
    <button id="grantAdmin"><?=__("grant_admin")?></button>
    <select id="customersSelect">
        <?php
            for ($i = 0; $i < count($customers); $i++) {
                echo "<option value='".$customers[$i]["User"]["id"]."'>".$customers[$i]["User"]["name"]." ".$customers[$i]["User"]["surname"].": ".$customers[$i]["User"]["email"]."</option>";
            }
        ?>
    </select>
    <button id="deleteCustomer"><?=__("delete_customer")?></button>
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
