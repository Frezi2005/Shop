<?php
	// debug(json_decode($_GET["products"], true));
	// die;
    require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");
    require_once (__DIR__.DS."..".DS."..".DS."..".DS."..".DS."..".DS."autoload.php");

    use NumberToWords\NumberToWords;

    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer(($_SESSION["language"] == 'pol') ? 'pl' : 'en');

    $faker = Faker\Factory::create();
	$faker->addProvider(new \Faker\Provider\pl_PL\Payment($faker));
	setlocale(LC_TIME, ($_SESSION["language"] == 'pol') ? 'Polish' : 'English_United_States');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$country = $user["User"]["country"];
	$city = $user["User"]["city"];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, "http://api.positionstack.com/v1/forward?access_key=$geoApiKey&query=$city, $country");
	$result = json_decode(curl_exec($ch), true)['data'][0];
	$lat = $result['latitude'];
	$lon = $result['longitude'];
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_URL,
		"http://api.geonames.org/findNearbyPostalCodesJSON?lat=$lat&lng=$lon&username=$zipCodeApiKey"
	);
	$chReturn = json_decode(curl_exec($ch), true)['postalCodes'];
	$postalCode = !empty($chReturn) ? $chReturn[0]['postalCode'] : "";
	curl_close($ch);

    $pdf->SetFont('dejavusans', '', 14, '', true);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);

    $pdf->AddPage();

	$unit = __("unit");
	$unitOfMeasure = __("unit_of_measure");

    $html = "";
    $index = 1;
    $products = json_decode(json_decode($_GET["products"], true)["Orders"]["products"], true);
    $sumWithoutTax = 0;
	$sumTax = 0;
	$sumWithTax = 0;
	$date = strtotime(json_decode($this->params["url"]["products"], true)["Orders"]["order_date"]);
	$orderDate = date('j F Y', $date);
	$invoiceNumberDate = date('Y/m/', $date);
	$invoiceNumber = strval($invoiceNumberDate).strval(sprintf("%02d", $invoice_number));
    foreach ($products as $product) {
        $html .= "<tr>
            <td>$index</td>
            <td style='text-align: left'>{$product["name"]}</td>
            <td>$unit</td>
            <td>{$product["count"]}</td>
            <td>".number_format(floatval($product["price"]) * 1.23, 2)."</td>
            <td>".number_format(floatval($product["price"]), 2)."</td>
			<td>23%</td>
            <td>".number_format(floatval($product["price"]) * floatval($product["count"]) * 0.23, 2)."</td>
			<td>".number_format(floatval($product["price"]) * floatval($product["count"]) * 1.23, 2)."</td>
        </tr>";
        $index++;
        $sumWithoutTax += floatval($product["price"]) * floatval($product["count"]);
        $sumTax += floatval($product["price"]) * floatval($product["count"]) * 0.23;
        $sumWithTax += floatval($product["price"]) * floatval($product["count"]) * 1.23;
    }

    $sumWords = $numberTransformer->toWords($sumWithTax);

	$whole = intval(number_format($sumWithTax, 2, ".", ""));
	$decimal1 = number_format($sumWithTax, 2, ".", "") - $whole;
	$decimal2 = number_format($decimal1, 2, ".", "");
	$decimal = substr($decimal2, 2);

	$bank = "ING Bank Śląski SA";
	$invoice = strtoupper(__("invoice_tax"));
	$bill = __("bill");
	$seller = __("seller");
	$buyer = __("buyer");
	$no = __("number");
	$index = __("index");
	$productName = __("product_name");
	$amount = __("amount");
	$netPrice = __("netto_price");
	$vat = __("vat");
	$totalVat = __("total_vat");
	$unitBruttoPrice = __("unit_brutto_price");
	$bruttoPrice = __("brutto_price");
	$bankTransfer = __("bank_transfer");
	$priceInWords = __("price_in_words");
	$total = __("total");
	$totalToPay = __("total_to_pay");
	$paymentDate = __("payment_date");
	$serviceDate = __("service_date");
	$vatRate = __("vat_rate");
	$vatValue = __("vat_value");
	$toPay = __("to_pay");
	$currency = json_decode($this->params["url"]["products"], true)["Orders"]["currency"];
	$paymentType = __(json_decode($this->params["url"]["products"], true)["Orders"]["payment_method"]);
	$paymentMethod = __("payment_method");
	$payed = __("payed");
	$sumWithTaxRounded = number_format($sumWithTax, 2);
	$sumWithoutTaxRounded = number_format($sumWithoutTax, 2);
	$sumTaxRounded = number_format($sumTax, 2);
	$name = ucfirst($user["User"]["name"]);
	$surname = ucfirst($user["User"]["surname"]);
	$street = $user["User"]["street"];
	$houseNumber = $user["User"]["house_number"];
	$html = <<<EOD
	<html>
		<style>
			* {
				font-family: 'Arial';
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			p {
				font-size: 10px;
				line-height: 4px;
			}

			td {
				border: 1px solid black;
				border-collapse: collapse;
				font-size: 7px;
				text-align: center;
				padding: 3px;
			}
		</style>
		<p style="text-align: right;">ul. Marii Konoponickiej 13, 43-100 Tychy</p>
		<p style="text-align: right;">60 064 87 45</p>
		<p style="text-align: right;">www.alphatech@alphatech.pl</p>
		<p>&nbsp;</p>
		<p style="text-align: right;">Tychy $orderDate</p>
		<h5 style="text-align: center; line-height: 8px;">$invoice: $invoiceNumber</h5>
		<table>
			<tr>
				<td style="width: 50%; text-align: left; border: none;">
					<p style="font-weight: bold;">$seller:</p>
					<p style="font-weight: bold;">AlphaTech sp. z. o.o</p>
					<p style="font-weight: bold;">43-100 Tychy, ul. Marii Konopnickiej 13</p>
					<p style="font-weight: bold;">$bill: $bank nr 25 1050 1142<br /><br /><br /><br /> 1000 0090 6674 7867</p>
					<p style="font-weight: bold;"><span>NIP: 9492107026</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>NIP EU: PL9492107026</span></p>
				</td>
				<td style="width: 50%; text-align: right; border: none;">
					<p style="font-weight: bold;">$buyer:</p>
					<p style="font-weight: bold;">ID: XU0036879</p>
					<p style="font-weight: bold;">$name $surname</p>
					<p style="font-weight: bold;">$postalCode $city, $street $houseNumber, $country</p>
				</td>
			</tr>
		</table>
		<br /><br /><br /><br /><br />
		<p>$serviceDate: $orderDate</p>
		<p>$paymentMethod: $paymentType</p>
		<p>$paymentDate: $orderDate</p>
		<table>
			<tr>
				<td style="width: 4%">$index</td>
				<td style="width: 52%;">$productName</td>
				<td style="width: 4%">$unitOfMeasure</td>
				<td style="width: 3%">$amount</td>
				<td style="width: 8%">$unitBruttoPrice</td>
				<td style="width: 8%">$netPrice</td>
				<td style="width: 5%">$vat</td>
				<td style="width: 8%">$totalVat</td>
				<td style="width: 8%">$bruttoPrice</td>
			</tr>
			$html
			<tr>
				<td style="border: none; border-top: 1px solid black" colspan="7">&nbsp;</td>
				<td style="border: none; border-top: 1px solid black; text-align: right;">$total&nbsp;&nbsp;</td>
				<td>$sumWithTaxRounded</td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<p style="line-height: 25px; font-size: 12px;">
			<table>
				<tr>
					<td style="border: none; width: 56%;">&nbsp;</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$vatRate</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$netPrice</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$vatValue</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$bruttoPrice</td>
				</tr>
				<tr>
					<td style="border: none; width: 56%;">&nbsp;</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">23%</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumWithoutTaxRounded</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumTaxRounded</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumWithTaxRounded</td>
				</tr>
				<tr>
					<td style="border: none; width: 56%;">&nbsp;</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$total:</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumWithoutTaxRounded</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumTaxRounded</td>
					<td style="border: none; border-bottom: 1px solid black; width: 11%;">$sumWithTaxRounded</td>
				</tr>
			</table>
		</p>
		<p>$toPay: $sumWithTaxRounded $currency</p>
		<p>$priceInWords: $sumWords $currency $decimal/100</p>
		<p>$payed: $paymentType $sumWithTaxRounded $currency</p>
	</html>
EOD;


    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output($name." ".$surname." - ".date('Y-m-d').".pdf", 'D');
?>
