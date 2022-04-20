<?php

App::uses("Component", "Controller");

class CheckPrivilegesComponent extends Component {
    public function check($site, $userID) {
        $user = ClassRegistry::init('User');
        foreach (Configure::read("hierarchy") as $key => $val) {
            if (strpos($site, $key) !== false) {
                if ($val == $user->find("first", array("conditions" => array("id" => $userID), "fields" => "role"))["User"]["role"]) {
                    return true;
                }
            }
        }
        return false;
    }
}