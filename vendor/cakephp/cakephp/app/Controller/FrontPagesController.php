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
class FrontPagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $components = array("Cookie");

	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();
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

	public function home() {
		// $this->SecurityUtils = $this->Components->load("PasswordHashing");
		// debug($this->SecurityUtils->encrypt("test12345"));
		$this->loadModel("Product");
		$this->set("randomProducts", $this->Product->find("all", array("order" => "rand()", "limit" => 4, "fields" => array("id", "name"))));
	}

	public function registerPage() 
	{

	}

	public function loginPage() {

	}

	public function getSubCategories() {
		$this->autoRender = false;
		$this->loadModel("SubCategory");
		$subCategories = [];
		$subCategories[$this->params["url"]["category-id"]] = $this->SubCategory->find("all", array("conditions" => array("category_id" => $this->params["url"]["category-id"])));
		return json_encode($subCategories);
	}

	public function changeLanguage() {
		$this->autoRender = false;
		$this->Session->write("language", $this->params["url"]["lang"]);
	}

	public function aboutUs() {

	}

	public function cooperation() {

	}

	public function contact() {
	
	}

	public function partnership() {

	}

	public function termsOfService() {

	}

	public function privacyPolicyAndCookies() {
		
	} 

	public function generateHashedPassword() {
		$this->autoRender = false;
		$this->SecurityUtils = $this->Components->load("PasswordHashing");
		debug($this->SecurityUtils->encrypt($this->params["url"]["p"]));
	}

	public function registerEmployeePage() {

	}

	public function siteMap() {
		
	}

	public function createRodoCookie() {
		$this->autoRender = false;
		$this->Cookie->write("rodo_accepted", true, false, "6 months");
		//$this->set("rodoCookie", $this->Cookie->read("rodo_accepted"));
	}

	public function errorTest() {
		$this->autoRender = false;
		throw new ForbiddenException();
	}

	public function giftsCatalog() {
		$this->loadModel("Gifts");
		$this->set("gifts", $this->Gifts->find("all"));
	}

	public function removeEmployeePage() {
		$this->loadModel("Users");
		$employees = $this->Users->find("all", array("conditions" => array("is_employee" => 1, "is_deleted" => 0, "is_admin" => 0), "fields" => array("id", "name", "surname", "email")));
		$arr = [];
		for ($i = 0; $i < count($employees); $i++) {
			$arr[$employees[$i]["Users"]["id"]] = $employees[$i]["Users"]["name"]." ".$employees[$i]["Users"]["surname"]." - ".$employees[$i]["Users"]["email"];
		}
		$this->set("employees", $arr);
	}

	public function askForAccount() {
		
	}

	public function forgotPasswordPage() {
		
	}
}
