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
class MailsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
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

	public function sendEmailFromCustomer() {
		$this->autoRender = false;
		$this->loadModel("User");
		$contactInfo = $this->request["data"]["contactForm"];
		$types = array("Opinion", "Complaint", "Cooperative offer", "Media contact", "Other");
		if (!in_array($contactInfo["messageType"], $types)) {
			$this->redirect("/contact");
		}
		if (!$this->Session->read("loggedIn")) {
			$subject = $contactInfo["messageType"]." from: ".$contactInfo["from"];
		} else {
			$user = $this->User->find("first", array("conditions" => array("id" => $this->Session->read("userUUID")), "fields" => array("email")));
			$subject = $contactInfo["messageType"]." from: ".$user["User"]["email"];
		}

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{
				\"personalizations\": [
					{
						\"to\": [
							{
								\"email\": \"kamil.wan05@gmail.com\"
							}
						],
						\"subject\": \"".$subject."\"
					}
				],
				\"from\": {
					\"email\": \"no-reply@alphatech.pl\"
				},
				\"content\": [
					{
						\"type\": \"text/plain\",
						\"value\": \"".$contactInfo["message"]."\"
					}
				]
			}",
			CURLOPT_HTTPHEADER => [
				"X-RapidAPI-Host: rapidprod-sendgrid-v1.p.rapidapi.com",
				"X-RapidAPI-Key: fdc08166b9mshdbd3ed3b4030c0fp1f1f9djsn7379b940a5c2",
				"content-type: application/json"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$this->Session->write("contactEmailSent", false);
		} else {
			$this->Session->write("contactEmailSent", true);
		}
		$this->redirect("/home");
	}

	public function sendForgotPasswordEmail() {
		$this->loadModel("User");
		$this->autoRender = false;
		$user = $this->User->find("first", array(
			"conditions" => array(
				"User.email" => $this->request["data"]["forgotPasswordForm"]["email"]
			)
		));

		if (count($user)) {
			$userId = base64_encode($user["User"]["id"]);

			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "{
					\"personalizations\": [
						{
							\"to\": [
								{
									\"email\": \"kamil.wan05@gmail.com\"
								}
							],
							\"subject\": \"Forgot password from AlphaTech\"
						}
					],
					\"from\": {
						\"email\": \"no-reply@alphatech.pl\"
					},
					\"content\": [
						{
							\"type\": \"text/plain\",
							\"value\": \"http://localhost/Shop/vendor/cakephp/cakephp/update-password-page?id=".$userId."\"
						}
					]
				}",
				CURLOPT_HTTPHEADER => [
					"X-RapidAPI-Host: rapidprod-sendgrid-v1.p.rapidapi.com",
					"X-RapidAPI-Key: fdc08166b9mshdbd3ed3b4030c0fp1f1f9djsn7379b940a5c2",
					"content-type: application/json"
				],
			]);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				$this->Session->write("forgotPasswordEmailSent", false);
			} else {
				$this->Session->write("forgotPasswordEmailSent", true);
			}
			$this->redirect("/login");
		} else {
			$this->Session->write("userNotFound", true);
			$this->redirect("/forgot-password-page");
		}
	}

	public function sendReplyToUser() {
		$this->autoRender = false;
		$this->loadModel("Message");
		$data = $this->request["data"]["replyForm"];
		$repliedBy = $this->Session->read("userUUID");
		$this->Message->save(array(
			"id" => CakeText::UUID(),
			"email" => $data["email"],
			"message" => $data["message"],
			"type" => "reply",
			"reply_to" => $data["id"],
			"reply_by" => $repliedBy
		));
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{
				\"personalizations\": [
					{
						\"to\": [
							{
								\"email\": \"".$data["email"]."\"
							}
						],
						\"subject\": \"Reply from AlphaTech\"
					}
				],
				\"from\": {
					\"email\": \"no-reply@alphatech.pl\"
				},
				\"content\": [
					{
						\"type\": \"text/plain\",
						\"value\": \"".$data["message"]."\"
					}
				]
			}",
			CURLOPT_HTTPHEADER => [
				"X-RapidAPI-Host: rapidprod-sendgrid-v1.p.rapidapi.com",
				"X-RapidAPI-Key: fdc08166b9mshdbd3ed3b4030c0fp1f1f9djsn7379b940a5c2",
				"content-type: application/json"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$this->Session->write("messageSent", $err ? false : true);
		$this->redirect("/view-messages");
	}
}
