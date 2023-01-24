<?php

    foreach ($messages as $message) {
        echo "<p>".$message["Message"]["email"]."(".__(strtolower(str_replace(" ", "_", $message["Message"]["type"])))."):<br/>".$message["Message"]["message"]."<br/><a href='reply-to-message?id=".$message["Message"]["id"]."'>".__("reply")."</a></p>";
    }

?>