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
class ProductsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Products");
		App::uses('CakeText', 'Utility');
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

	public function search() {
		$this->autoRender = false;
		if(strlen($this->params["url"]["q"]) <= 3) {
			$products = $this->Products->find("all", array(
				"fields" => array("id", "name", "description"),
				"conditions" => array(
					"name LIKE" => $this->params["url"]["q"]."%"
				),
				"limit" => 15
			));
		} else {
			$products = $this->Products->find("all", array("fields" => array("id", "name", "description"), "order" => "MATCH (`name`, `description`) AGAINST ('{$this->params["url"]["q"]}') DESC", "conditions" => array("MATCH (`name`, `description`) AGAINST ('{$this->params["url"]["q"]}') > 0")));
		}
		$result = [];
		foreach ($products as $product) {
			if (file_exists(WWW_ROOT."img/{$product["Products"]["id"]}.jpg")) {
				$product["Products"]["imgExists"] = true;
			} else {
				$product["Products"]["imgExists"] = false;
			}
			array_push($result, $product);
		}
		return json_encode($result);
	}

	public function product() {
		$product = $this->Product->find("first", array("conditions" => array("id" => $this->params["url"]["product_id"])))["Product"];
		$this->set("product", $product);
	}

	public function productsList() {
		$this->loadModel("SubCategory");
		$this->loadModel("Category");
		$this->loadModel("Filter");
		$sort = (isset($this->params["url"]["sort_by"])) ? $this->params["url"]["sort_by"] : "";
		$page = (isset($this->params["url"]["page"])) ? $this->params["url"]["page"] : 1;
		$productsShown = (isset($this->params["url"]["per_page"])) ? $this->params["url"]["per_page"] : Configure::read("Config.max_per_page");
		$priceRange = (isset($this->params["url"]["price_range"])) ? " BETWEEN ".explode("-", $this->params["url"]["price_range"])[0]." AND ".explode("-", $this->params["url"]["price_range"])[1] : "";
		switch ($sort) {
			case "price_asc":
				$sort_by = "price ASC";
				break;
			case "price_desc":
				$sort_by = "price DESC";
				break;
			case "name_asc":
				$sort_by = "name ASC";
				break;
			case "name_desc":
				$sort_by = "name DESC";
				break;
			default:
				$sort_by = "";
				break;
		}
		if (isset($this->params["url"]["category"])) {
			$products = $this->Category->find('all', array(
				'joins' => array(
					array(
						'table' => 'sub_categories',
						'alias' => 'SubCategoriesJoin',
						'type' => 'INNER',
						'conditions' => array(
							'SubCategoriesJoin.category_id = Category.id'
						)
					),
					array(
						'table' => 'products',
						'alias' => 'ProductsJoin',
						'type' => 'INNER',
						'conditions' => array(
							'ProductsJoin.sub_category_id = SubCategoriesJoin.id'
						)
					)
				),
				'conditions' => array(
					'category_id' => $this->params['url']['category']
				),
				'fields' => array('ProductsJoin.id', 'ProductsJoin.name', 'ProductsJoin.price', 'ProductsJoin.product_count'),
				'order' => array($sort_by),
				'recursive' => -1,
				'limit' => $page * $productsShown
			));

			for ($i = 0; $i < ($page - 1) * $productsShown; $i++) {
				array_shift($products);
			}

			$this->set("isCategory", true);
			$this->set("productsShown", $productsShown);
			$this->set("subCategoryId", $this->params["url"]["category"]);
			$this->set("products", $products);
			$this->set(
				"count", 
				ceil(count($this->Category->find('all', array(
					'joins' => array(
						array(
							'table' => 'sub_categories',
							'alias' => 'SubCategoriesJoin',
							'type' => 'INNER',
							'conditions' => array(
								'SubCategoriesJoin.category_id = Category.id'
							)
						),
						array(
							'table' => 'products',
							'alias' => 'ProductsJoin',
							'type' => 'INNER',
							'conditions' => array(
								'ProductsJoin.sub_category_id = SubCategoriesJoin.id'
							)
						)
					),
					'conditions' => array(
						'category_id' => $this->params['url']['category']
					),
					'fields' => array('ProductsJoin.id', 'ProductsJoin.name', 'ProductsJoin.price', 'ProductsJoin.product_count'),
					'order' => array($sort_by),
					'recursive' => -1
				))) / $productsShown)
			);
			return 0;
		} else if(isset($this->params["url"]["sub_category"])) {
			$subCategory = $this->SubCategory->find("first", array("conditions" => array("id" => $this->params["url"]["sub_category"]), "fields" => array("sub_category_name", "category_id")))["SubCategory"];
			$category = $this->Category->find("first", array("conditions" => array("id" => $subCategory["category_id"])))["Category"];
			$products = $this->Product->find('all', array(
				'conditions' => array(
					'sub_category_id' => $this->params['url']['sub_category']
				),
				'alias' => 'ProductsJoin',
				'fields' => array('id', 'name', 'price', 'product_count'),
				'order' => array($sort_by),
				'recursive' => -1,
				'limit' => $page * $productsShown
			));

			for ($i = 0; $i < ($page - 1) * $productsShown; $i++) {
				array_shift($products);
			}

			$this->set("isCategory", false);
			$this->set("productsShown", $productsShown);
			$this->set("subCategoryId", $this->params["url"]["sub_category"]);
			$this->set("products", $products);
			$this->set("subCategoryName", $subCategory["sub_category_name"]);
			$this->set("categoryName", $category["category_name"]);
			$this->set("categoryId", $category["id"]);
			$this->set(
				"count", 
				ceil(count($this->Product->find('all', array(
					'conditions' => array(
						'sub_category_id' => $this->params['url']['sub_category']
					),
					'alias' => 'ProductsJoin',
					'fields' => array('id', 'name', 'price', 'product_count'),
					'order' => array($sort_by),
					'recursive' => -1
				))) / $productsShown)
			);
			return 0;
		}
		if (!isset($this->params["url"]["q"])) {
			$subCategoryId = $this->SubCategory->find("first", array("conditions" => array("id" => $this->params["url"]["sub_category"]), "fields" => "id"))["SubCategory"]["id"];
			$products = $this->Product->find("all", array("conditions" => array("sub_category_id" => $subCategoryId, "price $priceRange"), "limit" => $page * $productsShown, "order" => array($sort_by)));
			if (isset($this->params["url"]["filters"])) {
				$filterCondition = "";
				$specsList = json_decode($products[0]["Product"]["specs"], true);
				$index = 0;
				if (isset($specsList)) {
					foreach ($specsList as $spec => $val) {
						$filters[$index] = [$spec => json_decode($this->Filter->find("first", array("conditions" => array("name" => strtolower($spec))))["Filter"]["filter_values"], true)];
						$index++;
					}
					for ($i = 0; $i < count($filters); $i++) {
						if (!isset($filters[$i][$this->params["url"]["filters"]])) { continue; };
						$filter = $filters[$i][$this->params["url"]["filters"]][$this->params["url"]["filtersValues"]];
						if ($filter) {
							if (preg_match('/\-\b/', $filter)) {
								$start = explode("-", $filter)[0];
								$end = explode("-", $filter)[1];
								$filterCondition = "JSON_EXTRACT(specs, '$.".$this->params["url"]["filters"]."') BETWEEN $start AND $end AND price $priceRange";
							} else if (preg_match('/[\+]/', $filter)) {
								$val = explode("+", $filter)[0];
								$filterCondition = "JSON_EXTRACT(specs, '$.".$this->params["url"]["filters"]."') * 1 > $val AND price $priceRange";
							} else {
								$filterCondition = "JSON_EXTRACT(specs, '$.".$this->params["url"]["filters"]."') = '$filter' AND price $priceRange";
							}
						}
					}
					$products = $this->Product->find("all", array("conditions" => array("sub_category_id" => $subCategoryId, $filterCondition), "limit" => $page * $productsShown, "order" => array($sort_by)));
				}
			}
		} else {
			$products = $this->Product->find("all", array("order" => "MATCH (`name`, `description`) AGAINST ('{$this->params["url"]["q"]}') DESC", "conditions" => array("MATCH (`name`, `description`) AGAINST ('{$this->params["url"]["q"]}') > 0")));
			$subCategoryId = "none";
		}

		for ($i = 0; $i < ($page - 1) * $productsShown; $i++) {
			array_shift($products);
		}

		$this->set("productsShown", $productsShown);
		$this->set("subCategoryId", $subCategoryId);
		$this->set("products", $products);
	}

	public function addProductToDatabase() {
		$this->loadModel("SubCategory");
		$id = CakeText::uuid();
		if (isset($this->request["data"]["addProductForm"])) {
			$productData = $this->request["data"]["addProductForm"];
			if (!empty($productData)) {
				if ($productData["image"]["size"] > 2048000) {
					$this->Session->write("sizeError", true);
				} else if (!preg_match('/^(0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*)$/', $productData["price"])) {
					$this->Session->write("priceError", true);
				} else {
					move_uploaded_file($productData["image"]["tmp_name"], WWW_ROOT."img/".$id.".jpg");
					$this->Product->save(array(
						"id" => $id,
						"name" => $productData["name"],
						"description" => $productData["description"],
						"specs" => $productData["specs"],
						"price" => $productData["price"],
						"discount_value" => 0.00,
						"shop_id" => NULL,
						"tax" => $productData["price"] * 0.23,
						"image" => "",
						"product_count" => rand(1, 1000),
						"sub_category_id" => $productData["subCategoryId"]
					));
				}
			}
		}

		$subCategoriesIds = $this->SubCategory->find("all", array("fields" => array("id", "sub_category_name")));

		$formatted = array();

		for ($i = 0; $i < count($subCategoriesIds); $i++) {
			foreach ($subCategoriesIds[$i] as $key => $value) {
				$formatted[$value["id"]] = __($value["sub_category_name"]);
			}
		}

		$this->set("subCategoriesIds", $formatted);
	}

	public function cart() {

	}

	public function returnProductsCount() {
		$this->autoRender = false;
		$subCategoryId = $this->params["url"]["id"];
		$productsCount = count($this->Product->find("all", array("conditions" => array("sub_category_id" => $subCategoryId))));
		return json_encode($productsCount);
	}

	public function inventory() {
		$this->loadModel("User");
		$isEmployee = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID")), "fields" => "is_employee"))["User"]["is_employee"];
		if (!$isEmployee) {
			throw new UnauthorizedException();
		}
		$this->set("products", $this->Product->find("all"));
	}

	public function order() {
		$this->loadModel("User");
		$countries = ["pol" => [], "eng" => []];
		foreach(json_decode(file_get_contents("../webroot/files/countries.json"), true) as $country) {
			$countries["pol"][$country["name_pl"]] = $country["name_pl"];
			$countries["eng"][$country["name_en"]] = $country["name_en"];
		}
		ksort($countries[$this->Session->read("language") ?? "eng"]);
		$countries["pol"] = array_merge(["Polska" => "Polska"], $countries["pol"]); 
		$countries["eng"] = array_merge(["Poland" => "Poland"], $countries["eng"]); 
		$countries[$this->Session->read("language") ?? "eng"] = array("" => __("choose")) + $countries[$this->Session->read("language") ?? "eng"];
		if($this->Session->read("loggedIn")) {
			$user = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID")), "fields" => array("country", "city", "street", "house_number", "flat_number", "email")));
			$this->set("userInfo", $user["User"]);
		}
		$this->set("countries", $countries[$this->Session->read("language") ?? "eng"]);
	}

	public function insertOrderToDB() {

	}

	public function deliveryForm() {
		$arr = [];
		$products = $this->Products->find("all", array("fields" => array("id", "name")));
		for ($i = 0; $i < count($products); $i++) {
			$arr[$products[$i]["Products"]["id"]] = $products[$i]["Products"]["name"];
		}
		$this->set("products", $arr);
	}

	public function addProductsFromDelivery() {
		$this->autoRender = false;
		$data = $this->request["data"]["deliveryForm"];
		if (preg_match('/\d/', $data["count"]) && intval($data["count"]) > 0) {
			for ($i = 0; $i < count($data["products"]); $i++) {
				$count = $this->Products->find("first", array("conditions" => array("id" => $data["products"][$i]), "fields" => array("product_count")));
				$this->Products->updateAll(array("product_count" => intval($count["Products"]["product_count"]) + $data["count"]), array("id" => $data["products"][$i]));
				$log = $this->Products->getDataSource()->getLog(false, false);
				$this->log($log);
			}
		} else {
			$this->Session->write("numberError", true);
		}
		$this->redirect("/delivery-form");
	}

	public function removeProductsForm() {
		$arr = [];
		$products = $this->Products->find("all", array("fields" => array("id", "name")));
		for ($i = 0; $i < count($products); $i++) {
			$arr[$products[$i]["Products"]["id"]] = $products[$i]["Products"]["name"];
		}
		$this->set("products", $arr);
	}

	public function removeProducts() {
		$this->autoRender = false;
		$data = $this->request["data"]["removeProductsForm"];
		$this->Products->deleteAll(array("id in" => $data["products"]));
		$this->redirect("/remove-products-form");
	}

	public function updateImageForm() {

	}

	public function updateImage() {
		$this->autoRender = false;
		$data = $this->request["data"]["updateProductForm"];
		if ($data["image"]["size"] < 2048000) {
			$product = $this->Products->find("first", array("conditions" => array("id" => $data["id"]), "fields" => array("name")));
			debug(WWW_ROOT."img/".$product["Product"]["name"].".jpg");
			die;
			move_uploaded_file($data["image"]["tmp_name"], WWW_ROOT."img/".$product["Product"]["name"].".jpg");
		}
	}

	public function invoice() {
		$this->loadModel("User");
		$this->loadModel("Order");
		$this->layout = false;	
		$userUUID = json_decode(urldecode($this->params["url"]["products"]), true)["Orders"]["user_id"];
		$user = $this->User->find("first", array("conditions" => array("id" => $userUUID), "fields" => array("name", "surname", "country", "city", "street", "house_number")));
		$date = strtotime(json_decode($this->params["url"]["products"], true)["Orders"]["order_date"]);
		$year = date('Y', $date);
		$month = date('m', $date);
		$this->set("geoApiKey", Configure::read("geoApiKey"));
		$this->set("zipCodeApiKey", Configure::read("zipCodeApiKey"));
		$this->set("invoice_number", $this->Order->find("first", array("conditions" => array("Month(order_date)" => $month, "Year(order_date)" => $year), "order" => array("order_date DESC"), "fields" => array("invoice_number")))["Order"]["invoice_number"]);
		$this->set("user", $user);
	}

	public function editProductForm() {
		$this->set("products", $this->Products->find("all", array("order" => array("name" => "asc"))));
	}

	public function editProduct() {
		$this->autoRender = false;
		$data = $this->params["url"];
		$this->Product->updateAll(array("name" => "'".$data["name"]."'", "description" => "'".$data["description"]."'", "specs" => "'".$data["specs"]."'", "price" => $data["price"], "discount_value" => $data["discount_value"], "sub_category_id" => "'".$data["sub_category_id"]."'"), array("id" => $data["id"]));
	}
}
