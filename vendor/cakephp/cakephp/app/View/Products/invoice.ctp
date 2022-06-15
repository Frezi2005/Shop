<?php
    require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");
    require_once (__DIR__.DS."..".DS."..".DS."..".DS."..".DS."..".DS."autoload.php");

    use NumberToWords\NumberToWords;

    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('pl');

    $faker = Faker\Factory::create();
    $faker->addProvider(new \Faker\Provider\pl_PL\Person($faker));

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetFont('dejavusans', '', 14, '', true);

    $pdf->AddPage();

    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

    $html = "";
    $index = 1;
    $products = json_decode(json_decode($_GET["products"], true)["Orders"]["products"], true);
    $sumWithTax = 0;
    foreach($products as $product) {
        $html .= "<tr>
            <td>$index</td>
            <td>{$product["name"]}</td>
            <td></td>
            <td>{$product["count"]}</td>
            <td>ddd</td>
            <td>{$product["price"]}</td>
            <td>23%</td>
            <td>".($product["price"] * $product["count"])."</td>
            <td>".($product["price"] * $product["count"] * 0.23)."</td>
            <td>".($product["price"] * $product["count"] * 1.23)."</td>
        </tr>";
        $index++;
        $sumWithoutTax = $product["price"] * $product["count"];
        $sumTax = $product["price"] * $product["count"] * 0.23;
        $sumWithTax += $product["price"] * $product["count"] * 1.23;
    }

    $decimal  = ($sumWithTax == (int) $sumWithTax) ? 0 : substr($sumWithTax,-2);
    $sumWords = $numberTransformer->toWords($sumWithTax);

    $html = <<<EOD
        <h2 style="width: 100%; background-color: #d4d4d4; border-top: 2px solid black; border-bottom: 2px solid black;">Faktura nr: 3/02-2022</h2>
        <br>
        <div>
            <table style="float: left; width: 300px;">
                <tr>
                    <th style="text-align: left; font-size: 25px; border-bottom: 2px solid black">Sprzedawca</th>
                </tr>
                <tr>
                    <td><b>Nazwa firmy</b></td>
                </tr>
                <tr>
                    <td><b>{$faker->streetAddress}</b></td>
                </tr>
                <tr>
                    <td><b>43-100 Tychy</b></td>
                </tr>
                <tr>
                    <td>NIP: <b>{$faker->taxpayerIdentificationNumber}</b></td>
                </tr>
                <tr>
                    <td>e-mail: <b>kamil.wan05@gmail.com</b></td>
                </tr>
            </table>
            <table style="float: right; width: 300px;">
                <tr>
                    <th style="text-align: left; font-size: 25px; border-bottom: 2px solid black">Nabywca</th>
                </tr>
                <tr>
                    <td><b>Kontrahent pojedynczy</b></td>
                </tr>
                <tr>
                    <td><b>43-100 Tychy</b></td>
                </tr>
                <tr>
                    <td>NIP: <b>{$faker->taxpayerIdentificationNumber}</b></td>
                </tr>
                <tr>
                    <td>tel: <b>48 987654321</b></td>
                </tr>
                <tr>
                    <td>e-mail: <b>kamil.wan05@gmail.com</b></td>
                </tr>
            </table>
        </div style="width: 100%">
        <br>
        <p style="float: left; width: 100%;margin: 40px 0 0 0;">Nr konta - {$faker->iban("PL")}</p>
        <p style="float: left; width: 100%;margin: 0 0 40px 0;">Nr SWIFT/BIC: BPKOPLPW</p>
        <p style="float: left; width: 100%;margin: 0;"><b>USD</b></p>
        <p style="float: left; width: 100%;margin: 0 0 40px 0;">Nr konta - {$faker->iban("PL")}</p>
        <table border="2" style="border-collapse: collapse; float: left;">
            <tr style="background-color: #e6e6e6">
                <th>lp.</th>
                <th>Nazwa towaru usługi</th>
                <th>Status produktu</th>
                <th>Ilość</th>
                <th>Jm</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Kwota netto</th>
                <th>Kwota VAT</th>
                <th>Kwota brutto</th>
            </tr>
            $html
            <tr>
                <td colspan="10" style="text-align: right">$sumWithTax</td>
            </tr>
        </table>
        <table border="2" style="border-collapse: collapse; float: right; margin-top: 20px;">
            <tr style="background-color: #e6e6e6">
                <th>Stawka VAT</th>
                <th>Netto</th>
                <th>VAT</th>
                <th>Brutto</th>
            </tr>
            <tr>
                <td>23%</td>
                <td>$sumWithoutTax</td>
                <td>$sumTax</td>
                <td>$sumWithTax</td>
            </tr>
            <tr>
                <td>Razem</td>
                <td>$sumWithoutTax</td>
                <td>$sumTax</td>
                <td>$sumWithTax</td>
            </tr>
        </table>
        <p style="float: left;width: 100%; text-align: right; margin: 0;font-size: 12px;">Sposób zapłaty: przelew</p>
        <p style="float: left;width: 100%;text-decoration: underline; font-size: 20px; background-color: #e6e6e6;font-weight: 900;text-align: right;">Razem do zapłaty: $sumWithTax PLN</p>
        <p style="float: left;width: 100%; text-align: right; font-size: 12px;">Kwota słownie: $sumWords USD $decimal/100</p>
        <p style="float: left; width: 35%; border-top: 2px dashed black; text-align: center; margin-top: 300px;">Osoba upoważniona do odbioru</p>
        <p style="float: right; width: 35%; border-top: 2px dashed black; text-align: center; margin-top: 300px;">Osoba upoważniona do wystawienia</p>
    EOD;

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $pdf->Output('example_001.pdf', 'D');

?>
