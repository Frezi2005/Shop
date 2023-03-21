<?php

    echo $this->Html->script("invoices");
    echo $this->Html->css("filter");
    echo $this->Html->css("form");

    echo "<div id='invoices' class='my-4 offset-1 col-xxl-6 col-xl-6 col-lg-7 col-10 float-start row row-cols-lg-2 row-cols-1 g-5 p-5 pt-1'>";
    
    if (!count($orders)) {
        echo "<p id='no-invoices' style='font-size: 50px; text-align: center; float: left; display: block; height: 100%; width: 100%; padding-top: 200px;'>".__("no_invoices")."</p>";
    } else {
        foreach ($orders as $order) {
            $fields = urlencode(str_replace("&", "&amp;", json_encode($order)));
			echo "<div class='col'>";
			echo "<div class='p-3 shadow rounded-3 bg-white'>";
            echo "<a href='invoice?products=$fields' target='_blank'>".date("Y-m-d", strtotime($order["Orders"]["order_date"]))." - ".$order["Orders"]["total_price"].$order["Orders"]["currency"]."<br/>".$order["Orders"]["user_id"]."</a><br/>";
			echo "</div>";
			echo "</div>";
		}
    }

    echo "</div>";
    
    echo <<<EOD
				<div id="filters" class="offset-1 col-xxl-3 col-xl-3 col-lg-2 col-10 float-start">
					<select id="sort">
						<option value="order_date-asc">${!${''} = __("date_ascending")}</option>
						<option value="order_date-desc">${!${''} = __("date_descending")}</option>
						<option value="total_price-asc">${!${''} = __("price_ascending")}</option>
						<option value="total_price-desc">${!${''} = __("price_descending")}</option>
					</select>
					<div class="row">
						<div class="col-lg-12 col-6 float-start"><input type="number" class="col-12" id="priceMin" placeholder="${!${''} = __("price_min")}"></div>
						<div class="col-lg-12 col-6 float-start"><input type="number" class="col-12" id="priceMax" placeholder="${!${''} = __("price_max")}"></div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-6 float-start"><input type="text" class="col-12" id="dateMin" placeholder="${!${''} = __("date_min")}"></div>
						<div class="col-lg-12 col-6 float-start"><input type="text" class="col-12" id="dateMax" placeholder="${!${''} = __("date_max")}"></div>
					</div>
					<p>${!${''} = __("payment_method")}</p>
					<select id="paymentMethod">
						<option value="" selected="selected">---</option>
						<option value="Credit card">${!${''} = __("credit_card")}</option>
						<option value="Bank transfer">${!${''} = __("bank_transfer")}</option>
						<option value="PayPal">PayPal</option>
						<option value="BLIK">BLIK</option>
					</select>
					<p>${!${''} = __("currency")}</p>
					<select id="currency">
						<option value="" selected="selected">---</option>
						<option value="EUR">EUR</option>
						<option value="USD">USD</option>
						<option value="GBP">GBP</option>
						<option value="PLN">PLN</option>
					</select>
					<button id="filter" class="col-12">${!${''} = __("filter")}</button>
				</div>
			<div class="col-10 offset-1 text-center filters-dropdown" data-open="false"><i class="fas fa-angle-right mx-2 filter-dropdown-arrow"></i>${!${''} = __("filters")}</div>	
		EOD;			
?>