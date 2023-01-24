<?php
    echo $this->Html->script("holidays_approval");
?>
<input type="hidden" id="pending" value="<?=$pending?>">
<div id="table" class="col-7 float-start">
    <div class="outer m-4">
        <table id="holidays"></table>
    </div>
</div>