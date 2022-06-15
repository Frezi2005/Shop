<?php
    echo $this->Html->css("order_history");
    echo $this->Html->script("order_history");
?>
<div id="orders">
    <select id="sortHistory">
        <option value="price_asc">Price ascending</option>
        <option value="price_desc">Price descending</option>
        <option value="date_asc">Date ascending</option>
        <option value="date_desc">Date descending</option>
    </select>
    <input type="number" id="priceMin" placeholder="price min">
    <input type="number" id="priceMax" placeholder="price max">
    <input type="date" id="dateMin">
    <input type="date" id="dateMax">
    <select id="paymentMethod">
        <option value="Credit card">Credit card</option>
        <option value="Bank transfer">Bank transfer</option>
        <option value="PayPal">PayPal</option>
        <option value="BLIK">BLIK</option>
    </select>
    <select id="currency">
        <option value="EUR">EUR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="PLN">PLN</option>
    </select>
    <button id="filter">Filter</button>
    <?php
        foreach ($orders as $order) {
            $products = json_decode($order["Orders"]["products"], true);
            $ids = array();
            foreach ($products as $product) {
                array_push($ids, $product["id"]);
            }
            $ids = json_encode($ids);
            $fields = json_encode($order);
            echo "<div class='order'><input type='hidden' value='{$ids}'/><input type='hidden' value='{$fields}' class='fields'/><span class='images'></span><span>{$order["Orders"]["delivery_type"]}</span><span>{$order["Orders"]["order_date"]}</span><span>{$order["Orders"]["total_price"]}</span><span>{$order["Orders"]["currency"]}</span><span><i class='fas fa-search'></i><a href='invoice?products=$fields' target='_blank'><i class='fas fa-file-invoice'></i></a></span></div>";       
        }
    ?>
</div>