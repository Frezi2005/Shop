<?php

    echo $this->Html->script("manage_budget");
    echo $this->Html->css("manage_budget");

	echo '<div class="offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 my-5 float-start">';
    echo "<select id='years' class='float-start'>";
    echo "<option value='' selected='selected'>---</option>";
    foreach ($years as $year) {
        echo "<option value='".$year."'>".$year."</option>";
    }
    echo "</select>";

?>

<h3 class="mx-3 float-start">
    <p>
		<?=__("budget");?>:
		<span id="sum"></span>
	</p>
</h3>
<table id="budget" class="table">
    <thead>
        <tr>
            <td><?=__("type");?></td>
            <td><?=__("price");?></td>
            <td><?=__("date");?></td>
            <td><?=__("where_from");?></td>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<div class="pagination">

</div>
</div>

