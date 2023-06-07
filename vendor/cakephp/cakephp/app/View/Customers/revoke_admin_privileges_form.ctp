<?php
	echo $this->Html->script("revoke_admin_privileges_form");

	echo "<select id='usersSelect'>";
	for ($i = 0; $i < count($employees); $i++) {
		echo "<option value='".$employees[$i]["User"]["id"]."'>".$employees[$i]["User"]["name"]." ".
			$employees[$i]["User"]["surname"].": ".$employees[$i]["User"]["email"]."</option>";
	}
	echo "</select>";
	echo "<button id='revokeAdmin'>".__("revoke_admin")."</button>";
?>
