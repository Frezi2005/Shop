<?php

    echo $this->Html->script("orders_report");
	echo $this->Html->css("orders_report");

?>
<div id="main">
	<div id="ordersReportForm">
		<input type="number" id="priceMin" placeholder="<?=__("price_min")?>">
		<input type="number" id="priceMax" placeholder="<?=__("price_max")?>">
		<input type="date" id="dateMin">
		<input type="date" id="dateMax">
		<select id="paymentMethod">
			<option value="Credit card"><?=__("credit_card")?></option>
			<option value="Bank transfer"><?=__("bank_transfer")?></option>
			<option value="PayPal">PayPal</option>
			<option value="BLIK">BLIK</option>
		</select>
		<select id="currency">
			<option value="EUR">EUR</option>
			<option value="USD">USD</option>
			<option value="GBP">GBP</option>
			<option value="PLN">PLN</option>
		</select>
		<button id="generate"><?=__("generate")?></button>
	</div>
</div>

