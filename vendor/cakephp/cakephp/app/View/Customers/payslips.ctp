<?php

	require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");
	require_once (__DIR__.DS."..".DS."..".DS."..".DS."..".DS."..".DS."autoload.php");

	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetFont('dejavusans', '', 9, '', true);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
	$pdf->AddPage();

	function format($n) {
		return number_format((float)$n, 2, '.', '');
	}

	$name = $employee["name"];
	$surname = $employee["surname"];
	$salary = $employee["salary"];
	$date = date("d-m-Y");

	$html = "
		<style>
			table, td {
				border-collapse: collapse;
			}

			table {
				border: 1px solid black;
			}

			th {
				background-color: #a9a9a9;
				padding: 10px;
				text-align: center;
			}

			.grey {
				background-color: #e8e8e9;
				text-align: right;
			}

			td {
				text-align: right !important;
			}
		</style>
		<table>
			<tr>
				<th colspan=\"4\">aaaa</th>
				<th colspan=\"3\">$name $surname</th>
				<th>07</th>
			</tr>
			<tr>
				<td colspan=\"2\" style=\"text-align: center;\">43-100 Tychy <br/>Testowa 43</td>
				<td class=\"grey\">Data:</td>
				<td>$date</td>
				<td colspan=\"2\" style=\"text-align: center;\">Wrocaaoignawoubawgujb</td>
				<td class=\"grey\">U.Skarb.</td>
				<td style=\"text-align: right;\">aoauwgbawigubaiub</td>
			</tr>
			<tr>
				<td class=\"grey\">NIP:</td>
				<td style=\"text-align: right;\">34567890986545678</td>
				<td class=\"grey\">Kartoteka:</td>
				<td style=\"text-align: right;\">luty</td>
				<td class=\"grey\">PESEL:</td>
				<td style=\"text-align: right;\">1234758326</td>
				<td class=\"grey\">NFZ:</td>
				<td style=\"text-align: right;\">01r</td>
			</tr>
			<tr>
				<td class=\"grey\">REGON:</td>
				<td style=\"text-align: right;\">0000000</td>
				<td class=\"grey\">Okres:</td>
				<td style=\"text-align: right;\">2345769547w</td>
				<td></td>
				<td></td>
				<td class=\"grey\">Etat:</td>
				<td style=\"text-align: right;\">8/8</td>
			</tr>
			<tr>
				<th colspan=\"2\">Rozliczenie czasu pracy</th>
				<th></th>
				<th></th>
				<th colspan=\"2\">Rozliczenia wynagrodzeń</th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<td class=\"grey\">Nominalne dni pracy:</td>
				<td style=\"text-align: right;\">20</td>
				<td class=\"grey\">Etat:</td>
				<td style=\"text-align: right;\">1</td>
				<td class=\"grey\">skladka emeryt.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0976)."</td>
				<td class=\"grey\">Wynagrodzenie netto:</td>
				<td style=\"text-align: right;\">".format($salary * 0.6967)."</td>
			</tr>
			<tr>
				<td class=\"grey\">Dni pracy:</td>
				<td style=\"text-align: right;\">20</td>
				<td class=\"grey\">Płaca zasadnicza:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Składka rent.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0150)."</td>
				<td class=\"grey\">R-k rozliczeniowy 1:</td>
				<td style=\"text-align: right;\">".format($salary * 0.6967)."</td>
			</tr>
			<tr>
				<td class=\"grey\">Nominalne godz.pracy:</td>
				<td style=\"text-align: right;\">160:00</td>
				<td class=\"grey\">Podst.wym.skł.E-R:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Składka chor.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0245)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class=\"grey\">Url.wypocz.do wykorzyst.(dni):</td>
				<td style=\"text-align: right;\">26</td>
				<td class=\"grey\">Podst.wym.skł.C-W:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Składka ZUS prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.1371)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class=\"grey\">Url.dodatk.do wykorzyst.(dni):</td>
				<td style=\"text-align: right;\">0</td>
				<td class=\"grey\">Składka emeryt.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0976)."</td>
				<td class=\"grey\">Podst.wym.skł.zdrow.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.8629)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Składka rent.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0650)."</td>
				<td class=\"grey\">Składka zdrow.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0777)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Składka wyp.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0167)."</td>
				<td class=\"grey\">Podatek dochodowy:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0886)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Składka ZUS zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.1793)."</td>
				<td class=\"grey\">Potrącenia razem:</td>
				<td style=\"text-align: right;\">".format($salary * 0.3033)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Wynagrodzenie brutto:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Przychód brutto:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<th colspan=\"8\">Rozliczenie dochodów i składek ZUS</th>
			</tr>
			<tr>
				<td class=\"grey\">Przychód brutto:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Podst.wym.skł.E-R:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Podst.wym.skł.C-W:</td>
				<td style=\"text-align: right;\">$salary</td>
				<td class=\"grey\">Podst.wym.skł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.8629)."</td>
			</tr>
			<tr>
				<td class=\"grey\">Podst.opodatkowania:</td>
				<td style=\"text-align: right;\">".format($salary * 0.8629)."</td>
				<td class=\"grey\">Składka emeryt.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0976)."</td>
				<td class=\"grey\">Składka emeryt.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0976)."</td>
				<td class=\"grey\">Składka zdrow.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0777)."</td>
			</tr>
			<tr>
				<td class=\"grey\">Podatek dochodowy</td>
				<td style=\"text-align: right;\">".format($salary * 0.0886)."</td>
				<td class=\"grey\">Składka rent.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0650)."</td>
				<td class=\"grey\">Składka rent.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0150)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Składka wyp.zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0167)."</td>
				<td class=\"grey\">Składka chor.prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.0245)."</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class=\"grey\">Składka ZUS zakł.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.1793)."</td>
				<td class=\"grey\">Składka ZUS prac.:</td>
				<td style=\"text-align: right;\">".format($salary * 0.1371)."</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	";

	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->Output("payslip.pdf", 'D');
?>
