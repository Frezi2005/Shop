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
    <a href="view-holidays"><?=__("view_holidays");?></a>
    <a href="notice-form"><?=__("request_notice");?></a>
    <a href="holidays-form"><?=__("request_holidays");?></a>
    <a href="sick-leave-form"><?=__("request_sick_leave");?></a>
    <a href="get-contract"><?=__("get_contract");?></a>
    <a href="regulations-of-loyalty-program-<?=$this->Session->read("language")?>"><?=__("rules_loyalty_program")?></a>
</div>
