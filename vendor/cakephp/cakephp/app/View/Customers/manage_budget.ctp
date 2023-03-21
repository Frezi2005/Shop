<?php

    echo $this->Html->script("manage_budget");

    echo "<select id='years'>";
    echo "<option value='' selected='selected'>---</option>";
    foreach ($years as $year) {
        echo "<option value='".$year."'>".$year."</option>";
    }
    echo "</select>";

?>

<p id="sum"></p>
<table id="budget">

</table>