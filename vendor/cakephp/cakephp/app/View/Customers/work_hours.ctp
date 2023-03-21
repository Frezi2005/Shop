<?php

    echo $this->Html->script("work_hours");
    echo $this->Html->css("work_hours");

?>
<input type="hidden" id="userId" value="<?=$this->Session->read("userUUID");?>"/>
<div class="offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start m-4">
    <select id="months">

    </select>
    <table id="calendar">
        <thead>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
            <th>Sun</th>
        </thead>
        <tbody></tbody>
    </table>
	<span id="hours"></span>
</div>
