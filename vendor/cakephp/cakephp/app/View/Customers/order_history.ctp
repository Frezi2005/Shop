<?php

    echo $this->Html->css("order_history");
    echo $this->Html->script("order_history");
    // require_once("..".DS."..".DS."..".DS."..".DS."tecnickcom".DS."tcpdf".DS."tcpdf.php");

    // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // $pdf->SetFont('dejavusans', '', 14, '', true);
    
    // $pdf->AddPage();
    
    // // set text shadow effect
    // $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    
    // $nrFaktury = "1/".date("m/Y");

    // $html = <<<EOD
    // <h1>Faktura nr: $nrFaktury</h1>
    // <i>This is the first example of TCPDF library.</i>
    // <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
    // <p>Please check the source code documentation and other examples for further information.</p>
    // <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
    // EOD;
    
    // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    
    // $pdf->Output('example_001.pdf', 'D');

?>
<div id="orders">
    <select id="sortHistory">
        <option value="price_asc">Price ascending</option>
        <option value="price_desc">Price descending</option>
        <option value="date_asc">Date ascending</option>
        <option value="date_desc">Date descending</option>
    </select>
    <?php
        foreach ($orders as $order) {
            $products = json_decode($order["Orders"]["products"], true);
            $ids = array();
            foreach ($products as $product) {
                array_push($ids, $product["id"]);
            }
            $ids = json_encode($ids);
            $fields = json_encode($order);
            echo "<div class='order'><input type='hidden' value='{$ids}'/><input type='hidden' value='{$fields}' class='fields'/><span class='images'></span><span>{$order["Orders"]["delivery_type"]}</span><span>{$order["Orders"]["order_date"]}</span><span>{$order["Orders"]["total_price"]}</span><span>{$order["Orders"]["currency"]}</span><span><i class='fas fa-search'></i><a href='invoice' target='_blank'><i class='fas fa-file-invoice'></i></a></span></div>";       
        }
    ?>
</div>