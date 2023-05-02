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
		$this->BudgetComponent = $this->Components->load("Budget");
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

	//Site responsible for managing the registration

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
			$this->User->save(
				array(
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
					"is_deleted" => 0,
				)
			);
			$this->Session->write("registeredModal", true);
		} catch (Exception $e) {
			$this->Log($e);
		}
		$this->redirect("/home");
	}

	//Site responsible for managing the login

	public function login() {
		$this->autoRender = false;
		$this->loadModel("Notice");
		$customerLoginData = $this->request["data"]["loginUserForm"];
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"email" => $customerLoginData["email"],
					"password" => $this->SecurityUtils->encrypt($customerLoginData["password"]
					)
				)
			)
		);
		if (!empty($user)) {
			$this->Session->write("loggedIn", true);
			$this->Session->write("loggedModal", true);
			$this->Session->write("userUUID", $user["User"]["id"]);
			if ($this->Session->read("orderInfo")) {
				$this->redirect("/order-products");
			} else {
				$this->redirect("/home");
			}
		} else {
			$this->Session->write("loginError", true);
			$this->redirect("/login");
		}
	}

	//Site responsible for activating customers account from link sent to their email

	public function activateCustomerAccount() {
		$this->autoRender = false;
		$this->User->id = $this->params["url"]["userUUID"];
		$this->User->saveField("verified", 1);
		$this->Session->write("verified", true);
		$this->redirect("/home");
	}

	//Site responsible for logging the user out

	public function logout() {
		$this->autoRender = false;
		$this->Session->write("loggedIn", false);
		$this->Session->write("userUUID", "");
		$this->redirect("/home");
	}

	//Site listing available settings sites

	public function settings() {
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				)
			)
		)["User"];
		$this->set("is_employee", 0);
		if ($user["is_employee"]) {
			$this->set("is_employee", 1);
		}
	}

	//Site reponsible for changing users password after form submittion

	public function changePassword() {
		$this->autoRender = false;
		$changePasswordData = $this->request["data"]["changePasswordForm"];

		if ($changePasswordData["newPasswordConfirm"] == $changePasswordData["newPassword"]) {
			$user = $this->User->find("first",
				array(
					"conditions" => array(
						"id" => $this->Session->read("userUUID")
					)
				)
			);
			if ($user) {
				$this->User->updateAll(
					array("password" => "'" . $this->SecurityUtils->encrypt($changePasswordData["newPassword"]) . "'"),
					array("id" => $this->Session->read("userUUID"))
				);
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

	//Site reponsible for managing employees registration

	public function registerEmployee() {
		$employee = $this->request["data"]["registerEmployeeForm"];
		$userUUID = CakeText::uuid();
		$randomPassword = "";
		for ($i = 0; $i < 6; $i++) {
			$randomPassword .= rand(0, 9);
		}

		$this->User->save(
			array(
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
			)
		);
		$this->redirect("/home");
	}

	//Site listing all employees and their most useful information

	public function listEmployees() {
		if (!$this->CheckPrivileges->check($_SERVER["REQUEST_URI"], $this->Session->read("userUUID"))) {
			throw new ForbiddenException();
		}
		$this->set("employees", $this->User->find("all", array("conditions" => array("is_employee" => 1))));
	}

	//Site listing available administrative tools

	public function adminPanel() {
		if (!$this->CheckPrivileges->check($_SERVER["REQUEST_URI"], $this->Session->read("userUUID"))) {
			throw new ForbiddenException();
		}
		$employees = $this->User->find("all", array("conditions" => array("is_employee" => 1, "is_admin" => 0)));
		$customers = $this->User->find("all",
			array(
				"conditions" =>
					array(
						"AND" => array(
							"is_employee" => 0,
							"name IS NOT NULL"
						)
					)
			)
		);

		$links = [
			"list-employees",
			"inventory",
			"remove-employee-page",
			"orders-report",
			"add-product-to-database",
			"delivery-form",
			"update-employee-page",
			"admin-privileges",
			"remove-customer",
			"holidays-approval-form"
		];

		$privileges = [];

		for ($i = 0; $i < count($links); $i++) {
			$privileges[$links[$i]] = $this->CheckPrivileges->check($links[$i], $this->Session->read("userUUID"));
		}

		$this->set("privileges", $privileges);
		$this->set("employees", $employees);
		$this->set("customers", $customers);
	}

	//Site reponsible for granting selected user admin privileges

	public function grantAdminPrivileges() {
		$this->autoRender = false;
		$userId = $this->params["url"]["id"];
		$this->User->updateAll(
			array("is_admin" => (isset($this->params["url"]["admin"])) ? 1 : 0),
			array("id" => $userId)
		);
	}

	//Site on which you can see all of your order history

	public function orderHistory() {
		$this->loadModel("Orders");
		$sort = (isset($this->params["url"]["sort"])) ? $this->params["url"]["sort"] : "";
		switch ($sort) {
			case "price_asc":
				$sort_by = "total_price ASC";
				break;
			case "price_desc":
				$sort_by = "total_price DESC";
				break;
			case "date_asc":
				$sort_by = "order_date ASC";
				break;
			case "date_desc":
				$sort_by = "order_date DESC";
				break;
			default:
				$sort_by = "order_date DESC";
				break;
		}

		$price = (isset($this->params["url"]["priceMin"])
			&& isset($this->params["url"]["priceMax"])
			&& !empty($this->params["url"]["priceMin"])
			&& !empty($this->params["url"]["priceMax"])) ?
			"total_price BETWEEN {$this->params["url"]["priceMin"]} AND {$this->params["url"]["priceMax"]}"
			: "total_price LIKE '%'";
		$date = (isset($this->params["url"]["dateMin"])
			&& isset($this->params["url"]["dateMax"])
			&& !empty($this->params["url"]["dateMin"])
			&& !empty($this->params["url"]["dateMax"])) ?
			"order_date BETWEEN '{$this->params["url"]["dateMin"]}' AND '{$this->params["url"]["dateMax"]}'"
			: "order_date LIKE '%'";
		$payment = (isset($this->params["url"]["payment"])
			&& !empty($this->params["url"]["payment"])) ?
			"payment_method = '{$this->params["url"]["payment"]}'"
			: "payment_method LIKE '%'";
		$currency = (isset($this->params["url"]["currency"])
			&& !empty($this->params["url"]["currency"])) ?
			"currency = '{$this->params["url"]["currency"]}'"
			: "currency LIKE '%'";
		$perPage = 10;
		$page = (!isset($this->params["url"]["page"])) ? 1 : $this->params["url"]["page"];
		$offset = (intval($page) - 1) * $perPage;
		$orders = $this->Orders->find("all", array(
			"conditions" => array(
				"user_id" => $this->Session->read("userUUID"),
				"order_date > now() - INTERVAL 2 year",
				$price,
				$payment,
				$currency,
				$date
			),
			"order" => $sort_by,
			"limit" => $perPage,
			"offset" => $offset)
		);
		$this->set("orders", $orders);
		$this->set("count",
			ceil(
				count($this->Orders->find("all",
					array(
						"conditions" => array(
							"user_id" => $this->Session->read("userUUID"),
							"order_date > now() - INTERVAL 2 year",
							$price,
							$payment,
							$currency,
							$date
						),
						"order" => array($sort_by)
					)
				)
			) / $perPage
			)
		);
		$this->set("page", $page);
	}

	//Site responsible for deleting users account
	public function deleteAccount() {
		$this->User->delete(array("id" => $this->Session->read("userUUID")));
		$this->redirect("/logout");
	}

	//Site responsible for deleting employees account
	public function removeEmployee() {
		$this->autoRender = false;
		$data = $this->request["data"]["removeEmployeesForm"];
		$this->User->updateAll(array("is_deleted" => 1), array("id" => $data["employees"]));
		$this->redirect("/remove-employee-page");
	}

	//Site responsible for making reports of orders
	public function ordersReport() {

	}

	//Update password page
	public function updatePasswordPage() {
		$id = base64_decode($this->params["url"]["id"]);
		$user = $this->User->find("first", array("conditions" => array("id" => $id)));
		if (count($user) == 0) {
			throw new InternalErrorException();
		}
		$this->set("id", $id);
	}

	//Site responsible for updating users password
	public function updatePassword() {
		$this->autoRender = false;
		$data = $this->request["data"]["updatePasswordForm"];
		if ($data["password"] == $data["passwordConfirm"]) {
			$this->User->updateAll(
				array("password" => "'" . $this->SecurityUtils->encrypt($data["password"]) . "'"),
				array("id" => $data["id"])
			);
			$this->Session->write("changePassword", true);
			$this->Session->write("loggedIn", true);
			$this->Session->write("loggedModal", true);
			$this->Session->write("userUUID", $data["id"]);
			$this->redirect("/home");
		}
	}

	//Site responsible for deleting specific users account
	public function removeCustomer() {
		$this->autoRender = false;
		$userId = $this->params["url"]["id"];
		$this->User->deleteAll(array("id" => $userId), false);
	}

	//Update employee page
	public function updateEmployeePage() {
		$employees = $this->User->find("all",
			array(
				"conditions" => array(
					"is_employee" => 1,
					"is_deleted" => 0
				),
				"fields" => array(
					"id",
					"name",
					"surname",
					"email",
					"salary",
					"bonus_amount",
					"holiday_amount"
				)
			)
		);
		$this->set("employees", $employees);
	}

	//Site responsible for updating employees info
	public function updateEmployee() {
		$this->autoRender = false;
		$data = $this->params["url"];
		$this->User->updateAll(
			array(
				"name" => "'" . $data["name"] . "'",
				"surname" => "'" . $data["surname"] . "'",
				"email" => "'" . $data["email"] . "'",
				"salary" => $data["salary"],
				"bonus_amount" => $data["bonus_amount"],
				"holiday_amount" => $data["holiday_amount"]
			),
			array(
				"id" => $data["id"]
			)
		);
	}

	//Site responsible for monitoring employees worktime
	public function monitorEmployeesWorktime() {
		$this->loadModel("Timeshift");
		$timeshifts = $this->Timeshift->find("all",
			array(
				"joins" => array(
					array(
						"table" => "users",
						"alias" => "User",
						"type" => "INNER",
						"conditions" => array(
							"Timeshift.user_id = User.id",
						),
					),
				),
				"conditions" => array("MONTH(Timeshift.date)" => date("m")),
				"group" => "Timeshift.user_id",
				"fields" => array("Timeshift.user_id", "SUM(Timeshift.hours) as hours", "User.name", "User.surname"),
			)
		);
		$this->set("employees", $timeshifts);
	}

	//Holidays request page
	public function holidaysForm() {
		$this->set("holidaysAmount",
			$this->User->find("first", array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				),
				"fields" => array(
					"holiday_amount"
				)
			)
		)["User"]["holiday_amount"]);
	}

	//Site responsible for sending a request for holidays
	public function requestHolidays() {
		$this->autoRender = false;
		$this->loadModel("Holiday");
		$data = $this->request["data"]["requestHolidaysForm"];
		$startDate = $data["start"]["year"] . "-" . $data["start"]["month"] . "-" . $data["start"]["day"];
		$endDate = $data["end"]["year"] . "-" . $data["end"]["month"] . "-" . $data["end"]["day"];
		$this->Holiday->save(
			array(
				"id" => CakeText::uuid(),
				"user_id" => $this->Session->read("userUUID"),
				"start" => $startDate,
				"end" => $endDate,
				"type" => $data["holidayType"],
				"status" => "pending",
				"request_date" => date("Y-m-d")
			)
		);
		$this->Session->write("leaveRequestSent", true);
		$this->redirect("/holidays-form");
	}

	//Holidays approval page
	public function holidaysApprovalForm() {
		if (!$this->CheckPrivileges->check($_SERVER["REQUEST_URI"], $this->Session->read("userUUID"))) {
			throw new ForbiddenException();
		}
		$this->loadModel("Holiday");
		$holidays = $this->Holiday->find("all",
			array(
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
				"fields" => array("User.name", "User.surname", "User.email", "User.holiday_amount", "Holiday.*")
			)
		);
		$this->set("pending", str_replace("\"", "'", json_encode($holidays, JSON_FORCE_OBJECT)));
	}

	//Site responsible for approving employees holidays requests
	public function approveHolidays() {
		$this->autoRender = false;
		$this->loadModel("Holiday");
		$userHolidayDaysLeft = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->params["url"]["userId"]
				),
				"fields" => array(
					"holiday_amount"
				)
			)
		)["User"]["holiday_amount"];
		if ($userHolidayDaysLeft >= intval($this->params["url"]["amount"])) {
			$this->User->updateAll(
				array("holiday_amount" => $userHolidayDaysLeft - intval($this->params["url"]["amount"])),
				array("id" => $this->params["url"]["userId"])
			);
			$this->Holiday->updateAll(
				array("status" => "'approved'"),
				array("id" => $this->params["url"]["holidayId"])
			);
			return true;
		}
		return false;
	}

	//Site responsible for rejecting employees holidays requests
	public function rejectHolidays() {
		$this->autoRender = false;
		$this->loadModel("Holiday");
		$this->Holiday->updateAll(array("status" => "'rejected'"), array("id" => $this->params["url"]["holidayId"]));
		return true;
	}

	//Site responsible for viewing your holidays
	public function viewHolidays() {
		$this->loadModel("Holiday");
		$this->set("holidaysHistory",
			$this->Holiday->find("all",
				array(
					"conditions" => array(
						"user_id" => $this->Session->read("userUUID")
					)
				)
			)
		);
	}

	//Site responsible for viewing your sick leaves
	public function viewSickLeave() {
		$this->loadModel("SickLeave");
		$this->set("sickLeaveHistory",
			$this->SickLeave->find("all",
				array(
					"conditions" => array(
						"user_id" => $this->Session->read("userUUID")
					)
				)
			)
		);
	}

	//Sick leave request page
	public function sickLeaveForm() {

	}

	//Site responsible for requesting sick leaves
	public function requestSickLeave() {
		$this->autoRender = false;
		$this->loadModel("SickLeave");
		$data = $this->request["data"]["requestSickLeaveForm"];
		$startDate = $data["start"];
		$endDate = $data["end"];
		$diff = (
			(
				date("Y", strtotime($endDate)) -
				date("Y", strtotime($startDate))
			) * 12
		) + (
			date("m", strtotime($endDate)) - date("m", strtotime($startDate))
		);
		if ($diff > 6) {
			$this->Session->write("sickLeaveDatesTooMuchDifference", true);
			$this->redirect("/sick-leave-form");
		}
		$this->SickLeave->save(
			array(
				"id" => CakeText::uuid(),
				"user_id" => $this->Session->read("userUUID"),
				"start" => $startDate,
				"end" => $endDate
			)
		);
		$this->Session->write("sickLeaveRequestSent", true);
		$this->redirect("/sick-leave-form");
	}

	//Site responsible for dowloading employees contract
	public function getContract() {
		$this->loadModel("Role");
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				)
			)
		)["User"];
		$this->set("user", $user);
		$this->set("role", $this->Role->find("first",
			array(
				"conditions" => array(
					"hierarchy" => $user["role"]
				)
			)
		)["Role"]["name"]);
	}

	//Notice request page
	public function noticeForm() {

	}

	//Fire employee page
	public function fireEmployeeForm() {
		$employees = $this->User->find("list",
			array(
				"conditions" => array(
					"is_employee" => 1,
					"id != '" . $this->Session->read("userUUID") . "'"
				),
				"fields" => array(
					"id",
					"email"
				)
			)
		);
		$this->set("employees", $employees);
	}

	//Site responsible for sending a notice request
	public function sendNoticeRequest() {
		$this->autoRender = false;
		if ($_SERVER["HTTP_REFERER"] == "http://localhost/Shop/vendor/cakephp/cakephp/notice-form") {
			$normal = true;
		} else {
			$normal = false;
		}
		$this->loadModel("Notice");
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $normal ?
						$this->Session->read("userUUID") : $this->request["data"]["fireEmployeeForm"]["employees"]
				),
				"fields" => array(
					"contract_start",
					"id"
				)
			)
		)["User"];
		if (!$this->Notice->find("count", array("conditions" => array("user_id" => $user["id"])))) {
			$start = $user["contract_start"];
			$end = date('Y-m-d');
			$ts1 = strtotime($start);
			$ts2 = strtotime($end);
			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);
			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);
			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			switch ($diff) {
				case $diff > 0 && $diff < 6:
					$date = date('Y-m-d', strtotime(
						date(
							'Y-m-d',
							strtotime('+ 1 weekdays')
						) . '+ 14 days')
					);
					break;
				case $diff >= 6 && $diff < 36:
					$date = date('Y-m-d', strtotime(
						date(
							'Y-m-d',
							strtotime('first day of next month')
						) . '+ 1 months')
					);
					break;
				case $diff >= 36:
					$date = date('Y-m-d', strtotime(
						date(
							'Y-m-d',
							strtotime('first day of next month')
						) . '+ 3 months')
					);
					break;
			}

			$date = date('Y-m-d', strtotime(date('Y-m-d', strtotime($date)) . '- 1 days'));
			$this->Notice->save(
				array(
					"id" => CakeText::uuid(),
					"user_id" => $normal ?
						$this->Session->read("userUUID") : $this->request["data"]["fireEmployeeForm"]["employees"],
					"type" => $this->request["data"][$normal ? "noticeRequestForm" : "fireEmployeeForm"]["noticeType"],
					"termination_date" => $date,
					"request_date" => date("Y-m-d H:i:s")
				)
			);
			$this->Session->write($normal ? "noticeRequestSent" : "employeeHasBeenFired", true);
		} else {
			$this->Session->write("noticeExistsError", true);
		}
		$this->redirect($normal ? "/notice-form" : "/fire-employee-form");
	}

	//Extend contract request page
	public function extendContractRequestForm() {
		$employees = $this->User->find("list",
			array(
				"conditions" => array(
					"is_employee" => 1,
					"id != '" . $this->Session->read("userUUID") . "'",
					"contract_end > NOW() AND contract_end < DATE_ADD(NOW(), INTERVAL 1 MONTH)"
				),
				"fields" => array(
					"id",
					"email"
				)
			)
		);
		$this->loadModel("Notice");
		foreach (array_keys($employees) as $k) {
			if ($this->Notice->find("count", array("conditions" => array("user_id" => $k)))) {
				unset($employees[$k]);
			}
		}
		$this->set("employees", $employees);
	}

	//Site responsible for extending a contract request
	public function extendContractRequest() {
		$this->autoRender = false;
		$this->loadModel("ContractExtend");
		try {
			$this->ContractExtend->save(
				array(
					"id" => CakeText::uuid(),
					"user_id" => $this->request["data"]["extendContractRequestForm"]["employees"],
					"extend" => $this->request["data"]["extendContractRequestForm"]["extend"],
				)
			);
			$this->Session->write("contractExtensionRequestSent", true);
		} catch (Exception $e) {
			$this->Session->write("contractExtensionRequestSent", false);
		}

		$this->redirect("/extend-contract-request-form");
	}

	//Site responsible for viewing contract extension requests
	public function viewContractExtensionRequests() {
		$this->loadModel("ContractExtend");
		$this->set("contractExtensions", $this->ContractExtend->find("all"));
	}

	//Site responsible for extending employees contract
	public function extendContract() {
		$this->autoRender = false;
		$this->loadModel("ContractExtend");
		$user = $this->User->find("first", array("conditions" => array("id" => $this->params["url"]["user_id"])));
		if ($user) {
			$this->ContractExtend->deleteAll(array("user_id" => $this->params["url"]["user_id"]));

			return $this->User->updateAll(
				array("contract_end" => "'" . $this->params["url"]["date"] . "'"),
				array("id" => $this->params["url"]["user_id"])
			);
		}
	}

	//Site responsible for deleting contract extensions request
	public function removeContractExtensionRequest() {
		$this->autoRender = false;
		$this->loadModel("ContractExtend");
		return json_encode($this->ContractExtend->deleteAll(array("user_id" => $this->params["url"]["user_id"])));
	}

	//Site responsible for buying gift
	public function buyGift() {
		$this->autoRender = false;
		$this->loadModel("Gift");
		if (empty($this->params["url"]["user_id"])) {
			throw new Exception('User not logged', 401);
		}
		$gift = $this->Gift->find("first", array("conditions" => array("id" => $this->params["url"]["id"])))["Gift"];
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->params["url"]["user_id"],
					"total_points >= " . intval($gift["points"])
				)
			)
		)["User"];
		if ($user) {
			$this->User->updateAll(
				array("total_points" => intval($user["total_points"]) - intval($gift["points"])),
				array("id" => $this->params["url"]["user_id"])
			);
			$this->Gift->updateAll(
				array("amount" => intval($gift["amount"]) - 1),
				array("id" => $this->params["url"]["id"])
			);
			return 1;
		} else {
			throw new Exception('Not enough points', 402);
		}
	}

	//Site responsible for managing and viewing the budget
	public function manageBudget() {
		$this->loadModel("Budget");
		$years = $this->Budget->find("all", array("group" => "year", "fields" => array("year")));
		for ($i = 0; $i < count($years); $i++) {
			$years[$i] = $years[$i]["Budget"]["year"];
		}
		$this->set("years", $years);
	}

	//Site responsible for getting all budget info
	public function getBudget() {
		$this->autoRender = false;
		$this->loadModel("Budget");
		return json_encode([
			$this->BudgetComponent->getBudgetIncome($this->params['url']['year']),
			$this->Budget->find("all",
				array(
					"conditions" => array(
						"year" => $this->params["url"]["year"]
					),
					"fields" => array(
						"ROUND(amount, 2) as amount",
						"type",
						"date",
						"from"
					),
					"order" => array(
						"date DESC"
					)
				)
			)
		]);
	}

	//Site repsonsible for reporting work hours
	public function workHours() {

	}

	//Site responsible for adding a timeshift to specific date
	public function addTimeshift() {
		$this->autoRender = false;
		$this->loadModel("Timeshift");
		$this->Timeshift->save(
			array(
				"id" => CakeText::uuid(),
				"user_id" => $this->params["url"]["user_id"],
				"date" => $this->params["url"]["date"],
				"hours" => strtotime($this->params["url"]["end"]) - strtotime($this->params["url"]["start"]),
				"start" => strtotime($this->params["url"]["start"]),
				"end" => strtotime($this->params["url"]["end"])
			)
		);
	}

	//Site responsible for getting all employees timeshifts
	public function getEmployeeTimeshifts() {
		$this->autoRender = false;
		$this->loadModel("Timeshift");
		return json_encode(
			$this->Timeshift->find("all",
				array(
					"conditions" => array(
						"`date` BETWEEN '" . $this->params["url"]["start_date"] .
						"' AND '" . $this->params["url"]["end_date"] . "'",
						"user_id" => $this->params["url"]["user_id"]
					),
					"fields" => array(
						"date",
						"hours",
						"start",
						"end"
					)
				)
			)
		);
	}

	//Site resposible for generating employees payslips
	public function payslips() {
		$user = $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				)
			)
		)["User"];
		$this->set("employee", $user);
	}

	//Site responsible for payouts
	public function payouts() {
		$this->set("employees",
			$this->User->find("all",
				array(
					"conditions" => array(
						"is_employee" => 1
					),
					"fields" => array(
						"id",
						"name",
						"surname",
						"MONTH(last_paycheck) as month"
					)
				)
			)
		);
		$holidays = $this->User->find("all",
			array(
				"joins" => array(
					array(
						"table" => "payouts",
						"alias" => "Payout",
						"type" => "INNER",
						"conditions" => array(
							"User.id = Payout.user_id"
						)
					)
				),
				"conditions" => array(
					"User.is_employee" => 1
				),
				"fields" => array("User.name", "User.surname", "User.email", "User.holiday_amount", "Holiday.*")
			)
		);
	}

	//Site responsible for handling employees's payouts
	public function handlePayouts() {
		$this->autoRender = false;
		$this->loadModel("Budget");
		$this->loadModel("Payout");
		$employees = json_decode($this->params["url"]["employees"]);

		$salaries = $this->User->find("list",
			array(
				"conditions" => array(
					"id" => $employees
				),
				"fields" => array(
					"id",
					"salary"
				)
			)
		);

		if (array_sum($salaries) > $this->BudgetComponent->getBudgetIncome(date("Y"))) {
			return -1;
		}

		foreach ($salaries as $id => $salary) {
			$this->Payout->save(
				array(
					"id" => CakeText::uuid(),
					"user_id" => $id,
					"payout_date" => date("Y-m-d"),
					"amount" => $salary,
					"commitment_date" => $this->params["url"]["year"] . "-" .
						str_pad($this->params["url"]["month"], 2, "0", STR_PAD_LEFT) . "-01"
				)
			);
		}

		$this->Budget->save(
			array(
				"id" => CakeText::uuid(),
				"type" => "exp",
				"amount" => array_sum($salaries),
				"currency" => "USD",
				"year" => date("Y"),
				"date" => date("Y-m-d"),
				"from" => "handlePayouts"
			)
		);
//		if ($salariesSum > $this->BudgetComponent->getBudgetIncome(date("Y"))) {
//			return -1;
//		}
//		$salaries = $this->User->find("list",
//			array(
//				"conditions" => array(
//					"id" => $employees
//				),
//				"fields" => array(
//					"id",
//					"salary"
//				)
//			)
//		);
//		$sum = 0;
//		foreach ($salaries as $id => $salary) {
//			$sum += floatval($salary);
//			$this->User->updateAll(array("last_paycheck" => "'".date("Y-m-d")."'"), array("id" => "$id"));
//		}
//		$this->Budget->save(
//			array(
//				"id" => CakeText::uuid(),
//				"type" => "exp",
//				"amount" => $sum,
//				"currency" => "USD",
//				"year" => date("Y"),
//				"date" => date("Y-m-d"),
//				"from" => "handlePayouts"
//			)
//		);
	}
}
