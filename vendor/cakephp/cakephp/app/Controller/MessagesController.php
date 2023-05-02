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
class MessagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

    public function beforeFilter() {
		parent::beforeFilter();
        App::uses('CakeText', 'Utility');
		$this->loadModel("Message");
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

	//Function responsible for saving sent message to database
    public function saveMessage() {
        $this->autoRender = false;
        $this->loadModel("User");
        $data = $this->request["data"]["contactForm"];
        $types = array("Opinion", "Complaint", "Cooperative offer", "Media contact", "Other");
		if (!in_array($data["messageType"], $types)) {
			$this->redirect("/contact");
		}

        $email = $this->Session->read("loggedIn") ? $this->User->find("first",
			array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				),
				"fields" => array(
					"email"
				)
			)
		)["User"]["email"] : $data["from"];
        try {
            $this->Message->save(
				array(
					"id" => CakeText::UUID(),
					"email" => $email,
					"message" => $data["message"],
					"type" => $data["messageType"],
					"reply_to" => null,
					"reply_by" => null
				)
			);
        } catch (Exception $e) {
            $this->Log($e);
            $this->Session->write("contactEmailSent", false);
            $this->redirect("/home");
        }
        $this->Session->write("contactEmailSent", true);
		$this->redirect("/home");
    }

	//View messages page
    public function viewMessages() {
		$perPage = 2;
		$page = (!isset($this->params["url"]["page"])) ? 1 : $this->params["url"]["page"];
		$offset = (intval($page) - 1) * $perPage;
		$sort = $this->params["url"]["sort_by"] ?? "date_desc";
		$replies = $this->Message->find("list",
			array(
				"conditions" => array(
					"type = 'reply'"
				),
				"fields" => array(
					"id",
					"reply_to"
				)
			)
		);
		$messages = $this->Message->find("all",
			array(
				"conditions" => array(
					"type != 'reply'",
					(isset($this->params["url"]["type"]) && urldecode($this->params["url"]["type"]) != "[]") ?
						"type IN " . str_replace(['[', ']'], ['(', ')'], urldecode($this->params["url"]["type"])) :
						""
				),
				"limit" => $perPage,
				"offset" => $offset,
				"order" => str_replace("_", " ", $sort)
			)
		);
		for ($i = 0; $i < count($messages); $i++) {
			if (in_array($messages[$i]["Message"]["id"], $replies)) {
				$messages[$i]["Message"]["replied"] = true;
				$messages[$i]["Message"]["reply"] = $this->Message->find("first",
					array(
						"conditions" => array(
							"id" => array_search($messages[$i]["Message"]["id"], $replies)
						)
					)
				)["Message"]["message"];
			} else {
				$messages[$i]["Message"]["replied"] = false;
			}
		}
		$this->set("count", ceil(count($this->Message->find("all",
			array(
				"conditions" => array(
					"type != 'reply'",
					(isset($this->params["url"]["type"]) && urldecode($this->params["url"]["type"]) != "[]") ?
						"type IN " . str_replace(['[', ']'], ['(', ')'], urldecode($this->params["url"]["type"])) :
						""
				)
			)
		)) / $perPage));
		$this->set("messages", $messages);
		$this->set("page", $page);
    }

	//Page for replying to user messages
    public function replyToMessage() {
        $message = $this->Message->find("first",
			array(
				"conditions" => array(
					"id" => $this->params["url"]["id"]
				)
			)
		)["Message"];
		$this->set("id", $this->params["url"]["id"]);
		$this->set("email", $message["email"]);
        $this->set("message", $message["message"]);
    }
}
