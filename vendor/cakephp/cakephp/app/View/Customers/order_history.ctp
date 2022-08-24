<?php
    echo $this->Html->css("order_history");
    echo $this->Html->script("order_history");
?>
<div id="orders" class="offset-1 col-xxl-6 col-xl-6 col-lg-7 col-10 float-start">
    <?php
		$ids = array();
        foreach ($orders as $order) {
            $products = json_decode($order["Orders"]["products"], true);
            $ids = array();
            foreach ($products as $product) {
                array_push($ids, $product["id"]);
            }
            $ids = json_encode($ids);
            $fields = json_encode($order);
			$date = explode(" ", $order["Orders"]["order_date"])[0];
			$hours = explode(" ", $order["Orders"]["order_date"])[1];
            echo "<div class='order'><input type='hidden' value='{$ids}'/><input type='hidden' value='{$fields}' class='fields'/><span class='images'></span><span>".__($order["Orders"]["delivery_type"])."</span><span>".$date." <span class='d-md-inline d-none'>".substr($hours, 0, -3)."</span></span><span>{$order["Orders"]["total_price"]}</span><span>{$order["Orders"]["currency"]}</span><span><i class='fas fa-search' title='".__("preview")."'></i><a href='invoice?products=$fields' target='_blank' title='".__("invoice")."'><i class='fas fa-file-invoice'></i></a></span></div>";
        }
//		echo "<i class='fas fa-angle-left'></i>";
//		for($i = 1; $i <= $count; $i++) {
//			echo ($i == $page) ? "<b>$i</b>" : $i;
//		}
//		echo "<i class='fas fa-angle-right'></i>";
    ?>

</div>
<div id="filters" class="offset-1 col-xxl-3 col-xl-3 col-lg-2 col-10 float-start">
	<select id="sortHistory">
		<option value="price_asc"><?=__("price_ascending")?></option>
		<option value="price_desc"><?=__("price_descending")?></option>
		<option value="date_asc"><?=__("date_ascending")?></option>
		<option value="date_desc"><?=__("date_descending")?></option>
	</select>
	<div class="row">
		<div class="col-lg-12 col-6 float-start"><p><?=__("price_min")?></p><input type="number" class="col-12" id="priceMin" placeholder="<?=__("price_min")?>"></div>
		<div class="col-lg-12 col-6 float-start"><p><?=__("price_max")?></p><input type="number" class="col-12" id="priceMax" placeholder="<?=__("price_max")?>"></div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-6 float-start"><p><?=__("date_min")?></p><input type="text" class="col-12" id="dateMin"></div>
		<div class="col-lg-12 col-6 float-start"><p><?=__("date_max")?></p><input type="text" class="col-12" id="dateMax"></div>
	</div>
	<p><?=__("payment_method")?></p>
	<select id="paymentMethod">
		<option value="Credit card"><?=__("credit_card")?></option>
		<option value="Bank transfer"><?=__("bank_transfer")?></option>
		<option value="PayPal">PayPal</option>
		<option value="BLIK">BLIK</option>
	</select>
	<p><?=__("currency")?></p>
	<select id="currency">
		<option value="EUR">EUR</option>
		<option value="USD">USD</option>
		<option value="GBP">GBP</option>
		<option value="PLN">PLN</option>
	</select>
	<button id="filter" class="col-12"><?=__("filter")?></button>
</div>
<div class="col-10 offset-1 text-center filters-dropdown" data-open="false"><i class="fas fa-angle-right mx-2"></i><?=__("filters")?></div>

