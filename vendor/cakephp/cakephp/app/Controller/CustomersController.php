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
class CustomersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		App::uses('CakeText', 'Utility');
		$this->loadModel("User");
		//Loading password hashing function
		//Using $this->SecurityUtils("test12345") results in: 
		//"3321c186b19869ee1be6a1c6791e669d64f3e56ba053dfdb3431caf06dbd6fb0ec1a7736af0ea45426fefdc4dfdf23bf08e86f75addf5168cad540bddb3cf743"
		$this->SecurityUtils = $this->Components->load("PasswordHashing");
		App::uses("CakeEmail", "Network/Email");
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

	public function register() {
		$this->autoRender = false;
		$customerRegisterData = $this->request["data"]["registerUserForm"];
		$this->Session->write("rememberedFieldsData", $customerRegisterData); 
		$this->User->set($customerRegisterData);
		$userUUID = CakeText::uuid();

		// $email = new CakeEmail("default");
		// $email->from(array("internetspam.pl@gmail.com" => "My Site"));
		// $email->to($customerRegisterData["email"]);
		// $email->subject("Email");
		// $email->send("http://localhost/Shop/vendor/cakephp/cakephp/activate-customer-account?userUUID=".$userUUID);
		try {
			$this->User->save(array(
				"id" => $userUUID,
				"name" => $customerRegisterData["name"],
				"surname" => $customerRegisterData["surname"],
				"email" => $customerRegisterData["email"],
				"password" => $this->SecurityUtils->encrypt($customerRegisterData["password"]),
				"birth_date" => $customerRegisterData["birthDate"],
				"phone_number" => $customerRegisterData["phoneNumber"],
				"total_points" => 0,
				"verified" => 0,
				"creation_date" => null,
				"is_employee" => 0
			));
			$this->Session->write("registeredModal", true);
		} catch (Exception $e) {
			$this->Log($e);
		}
		$this->redirect("/home");
	}

	public function login() {
		$this->autoRender = false;
		$customerLoginData = $this->request["data"]["loginUserForm"];
		$user = $this->User->find("first", array("conditions" => array("email" => $customerLoginData["email"], "password" => $this->SecurityUtils->encrypt($customerLoginData["password"]))));
		if (!empty($user)) {
			$this->Session->write("loggedIn", true);
			$this->Session->write("loggedModal", true);
			$this->Session->write("userUUID", $user["User"]["id"]);
			$this->redirect("/home");
		} else {
			$this->redirect("/login");
		}
	}

	public function activateCustomerAccount() {
		$this->autoRender = false;
		$this->User->id = $this->params["url"]["userUUID"];
		$this->User->saveField("verified", 1);
		$this->Session->write("verified", true);
		$this->redirect("/home");
	}

	public function logout() {
		$this->autoRender = false;
		$this->Session->write("loggedIn", false);
		$this->redirect("/home");
	}

	public function settings() {
		
	}

	public function changePassword() {
		$this->autoRender = false;
		$changePasswordData = $this->request["data"]["changePasswordForm"];
		if ($changePasswordData["newPasswordConfirm"] == $changePasswordData["newPassword"]) {
			$this->User->password = $this->SecurityUtils->encrypt($changePasswordData["currentPassword"]);
			$this->User->saveField("password", $this->SecurityUtils->encrypt($changePasswordData["newPassword"]));
			$this->Session->write("changePassword", true);
			$this->redirect("/logout");
		}
	}
}
