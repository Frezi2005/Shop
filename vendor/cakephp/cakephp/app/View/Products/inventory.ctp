<?php
    echo $this->Html->css("inventory");
?>
<div id="table" class="col-7 float-start">
    <div class="outer m-4">
        <table id="inventory">
            <tbody>
                <tr>
                    <th><?=__("product_name");?></th>
                    <th><?=__("description");?></th>
                    <th><?=__("price");?></th>
                    <th><?=__("amount");?></th>
                </tr>
                <?php
                    foreach ($products as $key => $value) {
                        echo "<tr>";
                            echo "<td>".$value["Product"]["name"]."</td>";
                            echo "<td>".$value["Product"]["description"]."</td>";
                            echo "<td>".$value["Product"]["price"]."</td>";
                            echo "<td>".$value["Product"]["product_count"]."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
