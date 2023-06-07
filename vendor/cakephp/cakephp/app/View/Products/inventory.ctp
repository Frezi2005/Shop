<?php
    echo $this->Html->css("inventory");
	echo $this->Html->script("inventory");
?>
<div id="table" class="float-start offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10">
    <div class="outer m-4">
        <table id="inventory" class="table bg-white">
            <thead>
                <tr>
                    <th><?=__("product_name");?></th>
                    <th><?=__("description");?></th>
                    <th><?=__("price");?></th>
                    <th><?=__("amount");?></th>
                </tr>
			</thead>
			<tbody>
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
		<?php

			if ($count > 1) {
				echo "<div class='pagination' data-count='$count'>";
				echo "<i class='fas fa-angle-left page-prev' data-page='-1'></i>";
				for ($i = $page - 2; $i <= $page + 2; $i++) {
					echo ($i > 0 && $i <= $count) ? (($i == $page) ? "<p class='bold'>$i</p>" : "<p>$i</p>") : "";
				}
				echo "<i class='fas fa-angle-right page-next' data-page='1'></i>";
				echo "</div>";
			}

		?>
    </div>
</div>
