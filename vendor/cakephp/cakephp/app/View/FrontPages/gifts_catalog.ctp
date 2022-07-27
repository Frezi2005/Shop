<?php

    echo $this->Html->script("gifts_catalog");

?>
<h1><?=__("gifts_catalog")?></h1>
<?php

    foreach ($gifts as $gift) {
        echo $gift["Gifts"]["name"]."<br/>";
        echo $gift["Gifts"]["points"]."<br/>";
        echo $gift["Gifts"]["amount"]."<br/>";
        echo "<button data-gift-id='".$gift["Gifts"]["id"]."' class='buyGift'>".__("buy_for_points")."</button>";
    }

?>
