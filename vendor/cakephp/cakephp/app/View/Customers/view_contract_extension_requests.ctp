<?php

    echo $this->Html->script("view_contract_extension_requests");

?>
<div id="table" class="col-7 float-start">
    <div class="outer m-4">
        <table id="contractExtensions">
            <?php
				if (!count($contractExtensions)) {
					echo "<h3>" . __("no_contract_extension_requests") . "</h3>";
				}
                foreach ($contractExtensions as $contract) {
                    echo "<tr>";
                        echo "<td>".$contract["ContractExtend"]["user_id"]."</td>";
                        echo "<td>".($contract["ContractExtend"]["extend"] ? "true" : "false")."</td>";
                        echo "<td><button class='btn btn-success accept' data-method='approve'>".__("submit").
							"</button><input type='date' placeholder='" . __("new_contract_date") . "'/></td>";
                        echo "<td><button class='btn btn-primary deny' data-method='reject'>".__("reject").
							"</button></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>
