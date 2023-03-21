<?php
    echo $this->Html->css("list_employees");
?>
<div id="list" class="float-start offset-1 col-xl-6 col-lg-5 col-10">
    <div class="outer m-4">
        <table>
            <tr>
                <th><?=__("index");?></th>
                <th><?=__("name_and_surname");?></th>
                <th><?=__("email");?></th>
                <th><?=ucfirst(__("salary"));?></th>
            </tr>
            <?php
                $i = 0;
                foreach ($employees as $employee) {
                    $i++;
                    echo "<tr class='employee'>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$employee["User"]["name"]." ".$employee["User"]["surname"]."</td>";
                    echo "<td>".$employee["User"]["email"]."</td>";
                    echo "<td>".$employee["User"]["salary"]."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>
