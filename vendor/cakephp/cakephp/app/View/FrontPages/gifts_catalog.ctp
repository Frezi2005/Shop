<?php

    echo $this->Html->script("gifts_catalog");

?>
<div id="gifts" class="my-4 offset-1 col-10 float-start">
    <input type="hidden" value="<?=$this->Session->read("userUUID");?>" id="userId"/>
    <h1><?=__("gifts_catalog")?></h1>
	<h3><?=__("total_points");?>: <?=$userPoints;?></h3>
    <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 g-5 p-5">
        <?php

            foreach ($gifts as $gift) {
                echo "<div class='col'>";
                echo "<div class='p-3 shadow rounded-3 bg-white'>";
                echo "<h3 class='mb-3'>".$gift["Gifts"]["name"]."</h3>";
                echo "<p>".__("price").": ". "<b>".$gift["Gifts"]["points"]."</b></p>";
                echo "<p>".__("quantity").": ". "<b>".$gift["Gifts"]["amount"]."</b></p>";
                echo "<button data-gift-id='".$gift["Gifts"]["id"]."' class='buyGift btn btn-outline-dark my-2'>".
					__("buy_for_points")."</button>";
                echo "</div>";
                echo "</div>";
            }

        ?>
    </div>
</div>
