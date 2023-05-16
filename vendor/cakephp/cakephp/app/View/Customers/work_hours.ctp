<?php

    echo $this->Html->script("work_hours");
    echo $this->Html->css("work_hours");

	echo "<input type='hidden' id='lang' value='" . $_SESSION["language"] . "'/>";

?>
<input type="hidden" id="userId" value="<?=$this->Session->read("userUUID");?>"/>
<div class="offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start m-4">
    <table id="calendar">
		<thead>
			<tr>
				<td colspan="7" id="selects">
					<select id="months" class="col-6 float-start"></select>
					<select id="years" class="col-6 float-start"></select>
				</td>
			</tr>
			<tr id="weekDays"></tr>
		</thead>
		<tbody></tbody>
    </table>
	<span id="hours"></span>
</div>
