<?php
    echo $this->Html->script("holidays_approval");
?>
<input type="hidden" id="pending" value="<?=$pending?>">
<div id="table" class="col-7 float-start">
    <table class="m-4" id="holidays"></table>
</div>