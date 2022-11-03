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

	/**
	 * beforeFilter loads all necessary models, components and other areas that provide certain functionalities.
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		App::uses('CakeText', 'Utility');
		$this->loadModel("User");
		$this->SecurityUtils = $this->Components->load("PasswordHashing");
		$this->CheckPrivileges = $this->Components->load("CheckPrivileges");
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
				"country" => null,
				"city" => null,
				"street" => null,
				"house_number" => null,
				"flat_number" => null,
				"phone_number" => $customerRegisterData["phoneNumber"],
				"total_points" => 0,
				"verified" => 0,
				"creation_date" => null,
				"id_number_and_series" => null,
				"salary" => null,
				"internship_length" => null,
				"bonus_amount" => null,
				"holiday_amount" => null,
				"is_employee" => 0,
				"shop_id" => null,
				"role" => null,
				"department" => null,
				"email_change_creation_date" => null,
				"email_change_expiration_date" => null,
				"is_admin" => 0,
				"is_deleted" => 0
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
			if($this->Session->read("orderInfo")) {
				$this->redirect("/order-products");
			} else {
				$this->redirect("/home");
			}
		} else {
			$this->Session->write("loginError", true);
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
		$this->Session->write("userUUID", "");
		$this->redirect("/home");
	}

	public function settings() {
		$user = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID"))))["User"];
		$this->set("is_employee", 0);
		if ($user["is_employee"]) {
			$this->set("is_employee", 1);
		}
	}

	public function changePassword() {
		// debug("test");
		// die;
		$this->autoRender = false;
		$changePasswordData = $this->request["data"]["changePasswordForm"];

		if ($changePasswordData["newPasswordConfirm"] == $changePasswordData["newPassword"]) {
			$user = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID"))));
			if($user) {
				$this->User->updateAll(array("password" => "'".$this->SecurityUtils->encrypt($changePasswordData["newPassword"])."'"), array("id" => $this->Session->read("userUUID")));
				$this->Session->write("changePassword", true);
				$log = $this->User->getDataSource()->getLog(false, false);
				$this->Log($log);
				$this->redirect("/logout");
			} else {
				$this->Session->write("userNotFoundError", true);
				$this->redirect("/change-password-form");
			}
		} else {
			$this->Session->write("passwordMatchError", true);
			$this->redirect("/change-password-form");
		}
	}

	public function registerEmployee() {
		$employee = $this->request["data"]["registerEmployeeForm"];
		$userUUID = CakeText::uuid();
		$randomPassword = "";
		for ($i = 0; $i < 6; $i++) {
			$randomPassword .= rand(0, 9);
		}

		$this->User->save(array(
			"id" => $userUUID,
			"name" => $employee["name"],
			"surname" => $employee["surname"],
			"email" => $employee["email"],
			"password" => $this->SecurityUtils->encrypt($randomPassword),
			"birth_date" => $employee["birthDate"],
			"country" => $employee["country"],
			"city" => $employee["city"],
			"street" => $employee["street"],
			"house_number" => $employee["houseNumber"],
			"flat_number" => $employee["flatNumber"],
			"phone_number" => $employee["phoneNumber"],
			"total_points" => 0,
			"verified" => 0,
			"creation_date" => date("Y-m-d H:i:s"),
			"id_number_and_series" => $employee["idNumberAndSeries"],
			"salary" => $employee["salary"],
			"internship_length" => $employee["internshipLength"],
			"bonus_amount" => $employee["bonusAmount"],
			"holiday_amount" => $employee["holidayAmount"],
			"is_employee" => 1,
			"shop_id" => null,
			"role" => null,
			"department" => null,
			"email_change_creation_date" => null,
			"email_change_expiration_date" => null,
			"is_deleted" => 0
		));
		$this->redirect("/home");
	}

	public function listEmployees() {
		if (!$this->CheckPrivileges->check($_SERVER["REQUEST_URI"], $this->Session->read("userUUID"))) {
			throw new ForbiddenException();
		}
		$this->set("employees", $this->User->find("all", array("conditions" => array("is_employee" => 1))));
	}

	public function adminPanel() {
		if (!$this->CheckPrivileges->check($_SERVER["REQUEST_URI"], $this->Session->read("userUUID"))) {
			throw new ForbiddenException();
		}
		$employees = $this->User->find("all", array("conditions" => array("is_employee" => 1, "is_admin" => 0)));
		$customers = $this->User->find("all", array("conditions" => array(
			"AND" => array(
				"is_employee" => 0,
				"name IS NOT NULL"
			)
		)));

		$links = [
			"list-employees",
			"inventory",
			"remove-employee-page",
			"orders-report",
			"add-product-to-database",
			"delivery-form",
			"update-employee-page",
			"admin-privileges",
			"remove-customer"
		];

		$privileges = [];

		for($i = 0; $i < count($links); $i++) {
			$privileges[$links[$i]] = $this->CheckPrivileges->check($links[$i], $this->Session->read("userUUID"));
		}

		$this->set("privileges", $privileges);
		$this->set("employees", $employees);
		$this->set("customers", $customers);
	}

	public function grantAdminPrivileges() {
		$this->autoRender = false;
		$userId = $this->params["url"]["id"];
		$this->User->updateAll(array("is_admin" => (isset($this->params["url"]["admin"])) ? 1 : 0), array("id" => $userId));
	}

	public function orderHistory() {
		$this->loadModel("Orders");
		$sort = (isset($this->params["url"]["sort_by"])) ? $this->params["url"]["sort_by"] : "";
		switch ($sort) {
			case "price_asc":
				$sort_by = "price ASC";
				break;
			case "price_desc":
				$sort_by = "price DESC";
				break;
			case "dater_asc":
				$sort_by = "order_date ASC";
				break;
			case "date_desc":
				$sort_by = "order_date DESC";
				break;
			default:
				$sort_by = "order_date DESC";
				break;
		}
		$price = (isset($this->params["url"]["priceMin"]) && isset($this->params["url"]["priceMax"]) && !empty($this->params["url"]["priceMin"]) && !empty($this->params["url"]["priceMax"])) ? "total_price BETWEEN {$this->params["url"]["priceMin"]} AND {$this->params["url"]["priceMax"]}" : "total_price LIKE '%'";
		$date = (isset($this->params["url"]["dateMin"]) && isset($this->params["url"]["dateMax"]) && !empty($this->params["url"]["dateMin"]) && !empty($this->params["url"]["dateMax"])) ? "order_date BETWEEN '{$this->params["url"]["dateMin"]}' AND '{$this->params["url"]["dateMax"]}'" : "order_date LIKE '%'";
		$payment = (isset($this->params["url"]["payment"]) && !empty($this->params["url"]["payment"])) ? "payment_method = '{$this->params["url"]["payment"]}'" : "payment_method LIKE '%'";
		$currency = (isset($this->params["url"]["currency"]) && !empty($this->params["url"]["currency"])) ? "currency = '{$this->params["url"]["currency"]}'" : "currency LIKE '%'";
		$perPage = 10;
		$page = (!isset($this->params["url"]["page"])) ? 1 : $this->params["url"]["page"];
		$offset = (intval($page) - 1) * $perPage;
		$orders = $this->Orders->find("all", array("conditions" => array("user_id" => $this->Session->read("userUUID"), "order_date > now() - INTERVAL 2 year", $price, $payment, $currency, $date), "order" => array($sort_by), "limit" => $perPage, "offset" => $offset));
		$log = $this->Orders->getDataSource()->getLog(false, false);
		$this->log($log);
		$this->set("orders", $orders);
		$this->set("count", ceil(count($this->Orders->find("all", array("conditions" => array("user_id" => $this->Session->read("userUUID"), "order_date > now() - INTERVAL 2 year", $price, $payment, $currency, $date), "order" => array($sort_by)))) / $perPage));
		$this->set("page", $page);
	}

	public function deleteAccount() {
		$this->User->delete(array("id" => $this->Session->read("userUUID")));
		$this->redirect("/logout");
	}

	public function removeEmployee() {
		$this->autoRender = false;
		$data = $this->request["data"]["removeEmployeesForm"];
		$this->User->updateAll(array("is_deleted" => 1), array("id" => $data["employees"]));
		$this->redirect("/remove-employee-page");
	}

	public function ordersReport() {

	}

	public function updatePasswordPage() {
		$id = base64_decode($this->params["url"]["id"]);
		$user = $this->User->find("first", array("conditions" => array("id" => $id)));
		if (count($user) == 0) {
			throw new InternalErrorException();
		}
		$this->set("id", $id);
	}

	public function updatePassword() {
		$this->autoRender = false;
		$data = $this->request["data"]["updatePasswordForm"];
		if ($data["password"] == $data["passwordConfirm"]) {
			$this->User->updateAll(array("password" => "'".$this->SecurityUtils->encrypt($data["password"])."'"), array("id" => $data["id"]));
			$this->Session->write("changePassword", true);
			$this->Session->write("loggedIn", true);
			$this->Session->write("loggedModal", true);
			$this->Session->write("userUUID", $data["id"]);
			$this->redirect("/home");
		}
	}

	public function removeCustomer() {
		$this->autoRender = false;
		$userId = $this->params["url"]["id"];
		$this->User->deleteAll(array("id" => $userId), false);
	}

	public function updateEmployeePage() {
		$employees = $this->User->find("all", array("conditions" => array("is_employee" => 1, "is_deleted" => 0), "fields" => array("id", "name", "surname", "email", "salary", "internship_length", "bonus_amount", "holiday_amount")));
		$this->set("employees", $employees);
	}

	public function updateEmployee() {
		$this->autoRender = false;
		$data = $this->params["url"];
		debug($data);
		$this->User->updateAll(array("name" => $data["name"], "surname" => $data["surname"], "email" => $data["email"], "salary" => $data["salary"], "internship_length" => $data["internship_length"], "bonus_amount" => $data["bonus_amount"], "holiday_amount" => $data["holiday_amount"]));
	}

	public function monitorEmployeesWorktime() {
		$this->set("employees", $this->User->find("all", array("conditions" => array("is_employee" => 1, "is_deleted" => 0))));
	}

	public function holidaysForm() {
		
	}

	public function requestHolidays() {
		$this->autoRender = false;
		$this->loadModel("Holiday");
		$data = $this->request["data"]["requestHolidaysForm"];
		$startDate = $data["start"]["year"]."-".$data["start"]["month"]."-".$data["start"]["day"];
		$endDate = $data["end"]["year"]."-".$data["end"]["month"]."-".$data["end"]["day"];
		// debug($startDate." - ".$endDate);
		// debug((strtotime($endDate) - strtotime($startDate)) / 86400 + 1);
		$this->Holiday->save(array(
			"id" => CakeText::uuid(),
			"user_id" => $this->Session->read("userUUID"),
			"start" => $startDate,
			"end" => $endDate,
			"type" => $data["holidayType"],
			"status" => "pending"
		));
		$this->Session->write("leaveRequestSent", true);
		$this->redirect("/holidays-form");
	}

	public function holidaysApprovalForm() {
		$this->loadModel("Holiday");
		$holidays = $this->Holiday->find("all", array(
			"joins" => array(
				array(
					"table" => "users",
					"alias" => "User",
					"type" => "INNER",
					"conditions" => array(
						"Holiday.user_id = User.id"
					)
				)
			),
			"conditions" => array(
				"Holiday.status" => "pending"
			),
			"fields" => array("User.name", "User.surname", "User.email", "Holiday.*")
		));
		$this->set("pending", str_replace("\"", "'", json_encode($holidays, JSON_FORCE_OBJECT)));
	}

	public function approveHolidays() {

	}
}
