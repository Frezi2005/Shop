<?php

App::uses("Component", "Controller");

class CheckPrivilegesComponent extends Component {
	//Function responsible for checking if specificer user can or can't enter specific page
    public function check($site, $userID) {
        $user = ClassRegistry::init('User');
		$re = '/[a-z\-]*(?=(\/|\?|))/';
		$str = str_replace("/Shop/vendor/cakephp/cakephp/", "", $site);
		preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
		$roles = Configure::read("hierarchy")[$matches[0][0]];
		if (is_array($roles)) {
			for ($i = 0; $i < count($roles); $i++) {
				if (empty($userID) && in_array(0, $roles)) {
					return true;
				} else if (empty($userID) && !in_array(0, $roles)) {
					return false;
				} else if ($roles[$i] == $user->find("first", array("conditions" => array("id" => $userID), "fields" => "role"))["User"]["role"]) {
					return true;
				}
			}
		} else {
			if ($roles == $user->find("first", array("conditions" => array("id" => $userID), "fields" => "role"))["User"]["role"]) {
				return true;
			}
		}
        return false;
    }
}
