<?php

    echo $this->Form->create("removeEmployeesForm", array("url" => "/remove-employee"));
    echo $this->Form->input("employees", array("options" => $employees));
    echo $this->Form->end("delete");

?>