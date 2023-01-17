<?php
    echo $this->Html->css("inventory");
?>
<div id="table" class="col-7 float-start">
    <table id="inventory" class="m-4">
        <tbody>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Amount</th>
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
