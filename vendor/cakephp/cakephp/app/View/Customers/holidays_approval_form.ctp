<?php

    echo $this->Html->script("holidays_approval");

?>
<input type="hidden" id="pending" value="<?=$pending?>">
<div id="table" class="col-7 float-start">
    <table class="table table-success table-striped m-4" id="holidays">
        <tbody></tbody>
    </table>
</div>