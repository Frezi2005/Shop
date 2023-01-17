<?php

    echo $this->Html->script("invoices");

    echo "<select id='sort'>";
        echo "<option value='order_date-asc'>Order date ascending</option>";
        echo "<option value='order_date-desc'>Order date descending</option>";
        echo "<option value='total_price-asc'>Total price ascending</option>";
        echo "<option value='total_price-desc'>Total price descending</option>";
    echo "</select><br />";
    
    foreach ($orders as $order) {
        $fields = urlencode(str_replace("&", "&amp;", json_encode($order)));
        echo "<a href='invoice?products=$fields' target='_blank'>".$order["Orders"]["order_date"]." - ".$order["Orders"]["total_price"].$order["Orders"]["currency"]." - ".$order["Orders"]["user_id"]."</a><br/>";
    }

?>