<?php

    echo $this->Html->css("profile");

?>

<div id="main">
    <p>Creation date: <?=$creation_date;?></p>
    <p>Total points: <?=$total_points;?></p>
    <p><a href="change-email">Change email</a></p>
    <p><a href="">Change password</a></p>
    <p><a href="">Change address</a></p>
    <?php 
        if($is_admin) {
            echo "<a href=\"admin-panel\">Admin Panel</a>";
        }
    ?>
    <a href="error-test">error test</a>
    <p><a href="delete-account">Delete account</a></p>
</div>