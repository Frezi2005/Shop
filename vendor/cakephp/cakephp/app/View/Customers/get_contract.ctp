<?php
    require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");
    require_once (__DIR__.DS."..".DS."..".DS."..".DS."..".DS."..".DS."autoload.php");

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetFont('dejavusans', '', 11, '', true);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);

    $pdf->AddPage();

    $contractStart = $user["contract_start"];
    $contractEnd = $user["contract_end"];
    $contractDate = date('Y-m-d', strtotime('-5 days', strtotime($contractStart)));
    $date = date("d.m Y");
    $name = $user["name"];
    $surname = $user["surname"];
    $salary = $user["salary"];

	$html = <<<EOD
    <table>
        <tr>
            <td style="width: 1%; text-align: left; border: none;">
            </td>
            <td style="width: 99%; text-align: right; border: none;">
                <p>Tychy, dnia $date r.</p>
            </td>
        </tr>
    </table>
    <br />
    <h1 style="width: 100%; text-align: center; text-decoration: underline;">UMOWA O PRACĘ</h1>
    <p>zawarta w dniu $contractDate w Tychach pomiędzy:</p>
    <p>
    	AlphaTech Sp. z. o.o
    	<i>należy wpisać dokładne dane pracodawcy (nazwa, adres, NIP, REGON, KRS) </i>
    	zwanym w dalszej części umowy <b>PRACODAWCĄ</b>
	</p>
    <p>
    	$name $surname
    	<i>należy wpisać dokładne dane pracownika (imię, nazwisko, adres, pesel, nr dowodu osobistego) </i>
    	zwanym dalek <b>PRACOWNIKIEM,</b>
    	<br/> łącznie zwani, w dalszej części Umowy <b>STRONAMI<b/>
	</p>
    <h2 style="width: 100%; text-align: center;">§ 1</h2>
    <p>Strony ustalają następujące warunki zatrudnienia:</p>
    <ol type="a">
        <li> rodzaj umówionej pracy (stanowisko):  $role,</li>
        <li> miejsce wykonywanie pracy:  zdalnie,</li>
        <li> wymiar czasu pracy:  40godz./tydz.,</li>
        <li> termin rozpoczęcia pracy:  $contractStart,</li>
        <li> termin wygaśnięcia umowy:  $contractEnd,</li>
        <li> wynagrodzenie miesięczne:  $salary USD.</li>
    </ol>
    <h2 style="width: 100%; text-align: center;">§ 2</h2>
    <ol>
        <li> Pracodawca powierza Pracownikowi obowiązki określone szczegółowo w załączniku nr 1 do niniejszej umowy,
        z którym Pracownik został zapoznany przy podpisaniu niniejszej Umowy.</li>
        <li> Pracownik zobowiązuje się do wykonywania powierzonych mu obowiązków przy zachowaniu należytej staranności
        oraz z zasotowaniem swojej najlepszej wiedzy.</li>
    </ol>
    <h2 style="width: 100%; text-align: center;">§ 3</h2>
    <p>
		Pracownik oświadcza, że zapoznał się z treścią obowiązującego u Pracodawcy regulaminu pracy oraz z innymi aktami
		wewnętrznymi i procedurami obowiązującymi u Pracodawcy, a takze przepisami dotyczącymi BHP i ochrony
		przecipożarowej i zobowiązuje do ich przestrzegania.
     </p>
    <h2 style="width: 100%; text-align: center;">§ 4</h2>
    <ol>
        <li> Wszelkie zmiany niniejszej Umowy wymagają dla swej ważności formy pisemnej.</li>
        <li>
        	W sprawach nieuregulowanych w przedmiotowej Umowie, zastosowanie mają odpowiednie przepisy Kodeksu Pracy.
        </li>
        <li> Umowę sporządzono w dwóch jednobrzmiących egzemplarzach, po jednym dla każdej ze stron.</li>
    </ol>
EOD;

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output($name." ".$surname.".pdf", 'D');
?>
