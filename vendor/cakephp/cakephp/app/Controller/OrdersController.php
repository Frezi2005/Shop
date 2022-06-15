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
class OrdersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		App::uses('CakeText', 'Utility');
		$this->loadModel("Orders");
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

	public function orderProducts() {
		$this->autoRender = false;
		$data = (isset($this->request["data"]["orderForm"])) ? $this->request["data"]["orderForm"] : $this->Session->read("orderInfo");
		$this->loadModel("Orders");
		$this->loadModel("Users");
		$this->loadModel("Products");

		$userUUID = CakeText::uuid();

		if (preg_match('/[^a-zA-Z\s]+/i', $data["countries"]) || preg_match('/[^a-zA-Z\s]+/i', $data["city"]) || preg_match('/[^a-zA-Z\s]+/i', $data["street"]) || !preg_match('/(\d+[a-z]|\d+)/i', $data["house_number"])) {
			$this->redirect("/order");
		}

		if (empty($this->Session->read("userUUID"))) {
			$this->Users->save(array(
				"id" => $userUUID,
				"name" => null,
				"surname" => null,
				"email" => null,
				"password" => null,
				"birth_date" => null,
				"country" => null,
				"city" => null,
				"street" => null,
				"house_number" => null,
				"flat_number" => null,
				"phone_number" => null,
				"total_points" => 0,
				"verified" => 0,
				"creation_date" => date("Y-m-d H:i:s"),
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
		}

		$products = json_decode($data["cart"], true);
		
		$this->Orders->save(array(
			"user_id" => (empty($this->Session->read("userUUID"))) ? $userUUID : $this->Session->read("userUUID"),
			"email" => $data["email"],
			"country" => $data["countries"],
			"city" => $data["city"],
			"street" => $data["street"],
			"flat_number" => $data["flat_number"],
			"house_number" => $data["house_number"],
			"products" => json_encode($products),
			"delivery_type" => $data["deliveryType"],
			"order_date" => date("Y-m-d H:i:s"),
			"shipment_date" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + 3 days")),
			"total_price" => intval($data["price"]),
			"payment_method" => $data["paymentMethod"],
			"payment_date" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + 1 days")),
			"order_points" => (empty($this->Session->read("userUUID"))) ? 0 : floor(intval($data["price"]) / 100),
			"promo_code_id" => null,
			"currency" => "USD",
			"shop_id" => null
		));

		if (!empty($this->Session->read("userUUID"))) {
			$user = $this->Users->find("first", array("conditions" => array("id" => $this->Session->read("userUUID")), "fields" => array("total_points")));
			$this->Users->updateAll(array("total_points" => intval($user["Users"]["total_points"]) + round(intval($data["price"]) / 100)), array("id" => $this->Session->read("userUUID")));
		}
	
		for ($i = 0; $i < count($products); $i++) {
			$count = $this->Products->find("first", array("conditions" => array("id" => $products[$i]["id"])));
			$this->Products->updateAll(array("product_count" => intval($count["Products"]["product_count"]) - intval($products[0]["count"])), array("id" => $products[$i]["id"]));
		}

		$this->Session->write("orderedModal", true);
		$this->redirect("/home");
	}

	public function getOrders() {
		$this->autoRender = false;
		$price = (isset($this->params["url"]["priceMin"]) && isset($this->params["url"]["priceMax"])) ? "total_price BETWEEN {$this->params["url"]["priceMin"]} AND {$this->params["url"]["priceMax"]}" : "";
		$date = (isset($this->params["url"]["dateMin"]) && isset($this->params["url"]["dateMax"])) ? "order_date BETWEEN '{$this->params["url"]["dateMin"]}' AND '{$this->params["url"]["dateMax"]}'" : "";
		$payment = (isset($this->params["url"]["payment"])) ? "payment_method = '{$this->params["url"]["payment"]}'" : "";
		$currency = (isset($this->params["url"]["currency"])) ? "currency = '{$this->params["url"]["currency"]}'" : "";
		$orders = $this->Orders->find("all", array("conditions" => array($price, $payment, $currency, $date)));
		return json_encode($orders);
	}
}
