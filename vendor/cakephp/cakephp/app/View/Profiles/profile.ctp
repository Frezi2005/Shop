<?php

    echo $this->Html->css("profile");

?>

<div id="main">
    <p><?=__("name")?>: <?=$name;?></p>
    <p><?=__("surname")?>: <?=$surname;?></p>
    <p><?=__("email")?>: <?=$email;?></p>
    <p><?=__("creation_date")?>: <?=$creation_date;?></p>
    <p><?=__("total_points")?>: <?=$total_points;?></p>
    <a href="gifts-catalog"><?=__("gifts_catalog")?></a>
    <a href="order-history"><?=__("order_history")?></a>
    <a href="view-holidays">View holidays</a>
    <a href="notice-form">Request notice</a>
    <a href="holidays-form">Request holidays</a>
    <a href="sick-leave-form">Request sick leave</a>
    <a href="get-contract">Get contract</a>
    <a href="regulations-of-loyalty-program-<?=$this->Session->read("language")?>"><?=__("rules_loyalty_program")?></a>
</div>
