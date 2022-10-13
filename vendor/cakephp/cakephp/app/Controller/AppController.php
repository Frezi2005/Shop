<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel("Category");
        $this->loadModel("SubCategory");
        $this->Session->read("language") ?? $this->Session->write("language", "eng");
        Configure::write("Config.language", $this->Session->read("language"));
		$locale = Configure::read('Config.language');
		if ($locale && file_exists(APP . 'View' . DS . $locale . DS . $this->viewPath . DS . $this->view . $this->ext)) {
			$this->viewPath = $locale . DS . $this->viewPath;
		}
        $categories = $this->Category->find("all");
        $subCategories = [];
        $allCategories = [];
        foreach ($categories as $category) {
            $sc = $this->SubCategory->find("all", array(
                "conditions" => array(
                    "SubCategory.category_id" => $category["Category"]["id"]
                )
            ));
            for ($i = 0; $i < count($sc); $i++) {
                $subCategories[$i] = [
                    "id" => $sc[$i]["SubCategory"]["id"],
                    "sub_category_name" => $sc[$i]["SubCategory"]["sub_category_name"]
                ];
            }
            $allCategories[$category["Category"]["category_name"]] = [
                "category_id" => $category["Category"]["id"],
                "sub_categories" => $subCategories
            ];
            $subCategories = [];
        }
		$this->set("categories", $allCategories);
    }
}
