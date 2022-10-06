<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses("AppController", "Controller");

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ProfilesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("User");
	}

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect("/");
		}
		if (in_array("..", $path, true) || in_array(".", $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact("page", "subpage", "title_for_layout"));

		try {
			$this->render(implode("/", $path));
		} catch (MissingViewException $e) {
			if (Configure::read("debug")) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function profile() {
		$user = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID"))))["User"];
		$this->set("name", $user["name"]);
		$this->set("surname", $user["surname"]);
		$this->set("email", $user["email"]);
		$this->set("creation_date", $user["creation_date"]);
		$this->set("total_points", $user["total_points"]);
	}

	public function changeAddress() {
		$this->loadModel("Users");
		$this->autoRender = false;
		$data = $this->request["data"]["changeAddressForm"];
		foreach($data as $key => $value) {
			$data[$key] = "'".$value."'";
			if(preg_replace('/\s+/', '', $value) == "") {
				$this->Session->write("changeAddressError", true);
				$this->redirect("/change-address-form");
			}
		}
		$this->Users->updateAll($data, array("id" => $this->Session->read("userUUID")));
		$this->Session->write("changedAddress", true);
		$this->redirect("/");
	}

	public function changeAddressForm() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, "http://country.io/names.json");
		$result = curl_exec($ch);
		curl_close($ch);

		$countries = array();
		$obj = json_decode($result, true);
		foreach ($obj as $k => $v) {
			if ($v != "Russia") {
				$countries[$v] = $v;
			}
		}

		ksort($countries);
		$countries = array("" => "") + $countries;
		$this->set("countries", $countries);
	}

	public function changeEmailForm() {
		$this->loadModel("User");
		$this->set("email", $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID")), "fields" => array("email")))["User"]["email"]);
	}

	public function sendChangeEmail() {
		$this->autoRender = false;
		require_once '../../../../autoload.php';
		$this->loadModel("User");
		$this->SecurityUtils = $this->Components->load("PasswordHashing");
		$changeEmailData = $this->request["data"]["changeEmailForm"];
		$user = $this->Users->find("first", array("conditions" => array("email" => $changeEmailData["currentEmail"], "password" => $this->SecurityUtils->encrypt($changeEmailData["password"]))));
		$this->Users->updateAll(array("email_change_creation_date" => "'".date("Y-m-d H:i:s")."'", "email_change_expiration_date" => "'".date("Y-m-d H:i:s", strtotime("+1 hours"))."'", "new_email" => "'".$changeEmailData["newEmail"]."'"), array("password" => $this->SecurityUtils->encrypt($changeEmailData["password"])));
		$this->Session->write("data", $changeEmailData);
		if ($user) {
			$transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
				->setUsername('internetspam.pl@gmail.com')
				->setPassword('internetspam.pl');

			$mailer = new Swift_Mailer($transport);

			$message = (new Swift_Message('Change email'))
				->setFrom(['internetspam.pl@gmail.com' => 'AlphaTech'])
				->setTo(['kamil.wan05@gmail.com'])
				->setBody('');

			if ($mailer->send($message)) {
				$this->Session->write("changeEmailSent", true);
				$this->redirect("/logout");
			}
		} else {
			$this->Session->write("changeEmailError", true);
			$this->redirect("/change-email-form");
		}
	}

	public function changeEmail() {
		$this->loadModel("Users");
		$user = $this->Users->find("first", array("conditions" => array("id" => $this->params["url"]["id"])));
		debug($user);
		die;
	}

	public function changePasswordForm() {

	}
}
