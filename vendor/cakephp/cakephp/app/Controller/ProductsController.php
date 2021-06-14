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
		$products = $this->Product->find("all", array("fields" => array("name", "id")));
		$words = [];
		$results = [];
		$index = 0;
		foreach (explode(" ", $this->params["url"]["q"]) as $word) {
			array_push($words, $word);
		}
		foreach ($products as $product) {
			$wordsInProductName = [];
			$productScore = 0;
			$productName = $product["Product"]["name"];
			foreach (explode(" ", $productName) as $productWord) {
				array_push($wordsInProductName, $productWord);
			}
			for ($i = 0; $i < count($words); $i++) {
				$bestWordSimPerc = 0;
				for ($j = 0; $j < count($wordsInProductName); $j++) {
					$wordSim = similar_text(strtolower($wordsInProductName[$j]), strtolower($words[$i]), $wordSimPerc);
					if ($wordSimPerc > $bestWordSimPerc) $bestWordSimPerc = $wordSimPerc;
				}
				if (strpos(strtolower($productName), strtolower($words[$i])) !== false) {
					$productScore++;
				}
			}
			// if($productScore == 0) continue;
			$sim = similar_text(strtolower($this->params["url"]["q"]), strtolower($productName), $perc);
			$totalScore = intval($productScore)+intval(ceil(floatval($perc)))+intval(ceil(floatval($bestWordSimPerc)));
			$results["product$index"] = ["name" => $productName, "totalScore" => $totalScore, "id" => $product["Product"]["id"]];
			$index++;
		}
		return json_encode($results);
	}

	public function product() {
		$product = $this->Product->find("first", array("conditions" => array("id" => $this->params["url"]["product_id"])))["Product"];
		$this->set("product", $product);
		// $this->set("name", $product["name"]);
		// $this->set("description", $product["description"]);
		// $this->set("price", $product["price"]);
		// $this->set("image", $product["image"]);
		// $this->set("product_count", $product["product_count"]);
	}
}
