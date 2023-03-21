<?php

    echo $this->Html->css("view_messages");
    echo $this->Html->script("view_messages");

    echo "<div id='messages' class='offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start my-4'>";
	echo "Pokaż wiadomości z odpowiedziami: <input type='checkbox' id='showReplied'>";
	echo "<select id='messageType' multiple='true'>";
        echo "<option value='Opinion'>".__("opinion")."</option>";
        echo "<option value='Complaint'>".__("complaint")."</option>";
        echo "<option value='Cooperative offer'>".__("cooperative_offer")."</option>";
        echo "<option value='Media contact'>".__("media_contact")."</option>";
        echo "<option value='Other'>".__("other")."</option>";
    echo "</select>";
	echo "<select id='sort'>";
		echo "<option value='date_asc'>".__("date_ascending")."</option>";
		echo "<option value='date_desc'>".__("date_descending")."</option>";
	echo "</select>";
    echo "<button id='filter'>".__("filter")."</button>";
    $i = 0;
    foreach ($messages as $message) {
        echo "<div class='float-start col-12 m-3'>";
            echo "<div class='message' data-bs-toggle='collapse' href='#message$i' role='button' aria-expanded='false' aria-controls='message$i'>";
                echo "<b>".$message["Message"]["email"]."(".__(strtolower(str_replace(" ", "_", $message["Message"]["type"])))."):</b>";
                if ($message["Message"]["replied"]) {
                    echo "<span> ✔️</span>";
                }
                echo "<br/>".$message["Message"]["message"]."<br/>";
                echo "<p class='text-secondary'>".$message["Message"]["date"]."<br/>";
            echo "</div>";
            if (!$message["Message"]["replied"]) {
                echo "<a href='reply-to-message?id=".$message["Message"]["id"]."'>".__("reply_to")."</a>";
            }
            if ($message["Message"]["replied"]) {
                echo "<div class='collapse' id='message$i'>";
                    echo "<p class='pt-3 px-3 mb-0'><b>".ucfirst(__("reply")).":</b> <br/>".$message["Message"]["reply"]."</p>";
                    echo "<p class='px-3 text-secondary'>".$message["Message"]["date"]."<br/>";
                echo "</div>";
            }
        echo "</div>";
        $i++;
    }
	if ($count > 1) {
		echo "<div class='pagination'>";
		echo "<i class='fas fa-angle-left page-prev' data-page='-1'></i>";
		for ($i = $page - 2; $i <= $page + 2; $i++) {
			echo ($i > 0 && $i <= $count) ? (($i == $page) ? "<p class='bold'>$i</p>" : "<p>$i</p>") : "";
		}
		echo "<i class='fas fa-angle-right page-next' data-page='1'></i>";
		echo "</div>";
	}

	echo "</div>";

    if ($this->Session->read("messageSent") == true) {
        echo "<script>Swal.fire({icon: \"success\",text: '".__("message_sent_successfully")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["messageSent"] = null;
    } else if ($this->Session->read("messageSent") === false) {
        echo "<script>Swal.fire({icon: \"error\",text: '".__("message_sent_unsuccessfully")."',showConfirmButton: true,timer: 5000,timerProgressBar: true});</script>";
        $_SESSION["messageSent"] = null;
    }

?>
