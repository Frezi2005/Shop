<?php

    echo $this->Html->script("view_contract_extension_requests");

?>
<div id="table" class="col-7 float-start">
    <div class="outer m-4">
        <table id="contractExtensions">
            <?php
                foreach ($contractExtensions as $contract) {
                    echo "<tr>";
                        echo "<td>".$contract["ContractExtend"]["user_id"]."</td>";
                        echo "<td>".($contract["ContractExtend"]["extend"] ? "true" : "false")."</td>";
                        echo "<td><button class='btn btn-success accept' data-method='approve'>".__("submit").
							"</button><input type='date' placeholder='Nowa data końca umowy'/></td>";
                        echo "<td><button class='btn btn-primary deny' data-method='reject'>".__("reject").
							"</button></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>
