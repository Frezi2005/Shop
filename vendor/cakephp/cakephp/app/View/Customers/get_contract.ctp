<?php
    require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");
    require_once (__DIR__.DS."..".DS."..".DS."..".DS."..".DS."..".DS."autoload.php");

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetFont('dejavusans', '', 14, '', true);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);

    $pdf->AddPage();

    $contractStart = $user["contract_start"];
    $contractEnd = $user["contract_end"];
    $contractDate = date('Y-m-d', strtotime('-5 days', strtotime($contractStart)));
    $name = $user["name"];
    $surname = $user["surname"];
    $salary = $user["salary"];

	$html = <<<EOD
    <table>
        <tr>
            <td style="width: 50%; text-align: left; border: none;">
                <p style="font-weight: bold;">AlphaTech Sp. z. o.o</p>
                <p style="font-weight: bold;">057205601</p>
            </td>
            <td style="width: 50%; text-align: right; border: none;">
                <p style="font-weight: bold;">Tychy, $contractDate</p>
            </td>
        </tr>
    </table>
    <br/>
    <h1 style="width: 100%; text-align: center;">Umowa o pracę</h1>
    <p style="width: 100%; text-align: left;">zawarta w dniu<p style="text-align: center; line-height: 4px;">$contractDate</p></p>
    <p style="width: 100%; text-align: left;">między<p style="text-align: center; line-height: 4px;">AlphaTech Sp. z. o.o</p></p>
    <p style="width: 100%; text-align: left;">a<p style="text-align: center; line-height: 4px;">$name $surname</p></p>
    <p style="width: 100%; text-align: left;">na<p style="text-align: center; line-height: 4px;">stałe zatrudnienie od $contractStart do $contractEnd</p></p>
    <p style="width: 100%; text-align: left;">1) rodzaj pracy<p style="text-align: center; line-height: 4px;">$role</p></p>
    <p style="width: 100%; text-align: left;">2) miejsce wykonywania pracy<p style="text-align: center; line-height: 4px;">zdalnie</p></p>
    <p style="width: 100%; text-align: left;">3) wymiar czasu pracy<p style="text-align: center; line-height: 4px;">pełny etat</p></p>
    <p style="width: 100%; text-align: left;">4) wynagrodzenie<p style="text-align: center; line-height: 4px;">$salary USD</p></p>
    <p style="width: 100%; text-align: left;">5) inne warunki zatrudnienia<p style="text-align: center; line-height: 4px;">----------</p></p>
    <p style="width: 100%; text-align: left;">6) termin rozpoczęcia pracy<p style="text-align: center; line-height: 4px;">$contractStart</p></p>

EOD;


    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output($name." ".$surname.".pdf", 'D');
?>
