<?php

    echo $this->Html->css("profile");

?>

<div id="main">
    <p>Name: <?=$name;?></p>
    <p>Surname: <?=$surname;?></p>
    <p>Email: <?=$email;?></p>
    <p>Creation date: <?=$creation_date;?></p>
    <p>Total points: <?=$total_points;?></p>
    <a href="gifts-catalog">Gifts catalog</a>
    <a href="order-history">Order history</a>
    <a href="">Regulamin programu lojalnościowego</a>
</div>