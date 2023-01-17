<div id="table" class="col-7 float-start">
    <table class="m-4" id="holidays">
        <tr>
            <th>Start</th>
            <th>End</th>
            <th>Type</th>
            <th>Status</th>
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
