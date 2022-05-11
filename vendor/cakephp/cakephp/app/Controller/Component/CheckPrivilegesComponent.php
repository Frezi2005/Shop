<?php

App::uses("Component", "Controller");

class CheckPrivilegesComponent extends Component {
    public function check($site, $userID) {
        $user = ClassRegistry::init('User');
        foreach (Configure::read("hierarchy") as $key => $val) {
            if (strpos($site, $key) !== false) {
                if (is_array($val)) {
                    for ($i = 0; $i < count($val); $i++) {
                        if ($val[$i] == $user->find("first", array("conditions" => array("id" => $userID), "fields" => "role"))["User"]["role"]) {
                            return true;
                        }
                    }
                } else {
                    if ($val == $user->find("first", array("conditions" => array("id" => $userID), "fields" => "role"))["User"]["role"]) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}