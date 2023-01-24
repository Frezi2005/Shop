<div id="table" class="col-7 float-start">
    <div class="outer m-4">
        <table id="holidays">
            <tr>
                <th><?=__("start");?></th>
                <th><?=__("end");?></th>
                <th><?=__("type");?></th>
                <th><?=__("status");?></th>
            </tr>
            <?php
                foreach ($holidaysHistory as $key => $value) {
                    echo "<tr>";
                        echo "<td>".$value["Holiday"]["start"]."</td>";
                        echo "<td>".$value["Holiday"]["end"]."</td>";
                        echo "<td>".$value["Holiday"]["type"]."</td>";
                        echo "<td>".$value["Holiday"]["status"]."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>
