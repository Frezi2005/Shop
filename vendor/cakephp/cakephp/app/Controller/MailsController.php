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

	//Function responsible for sending the message from contact form
	public function sendEmailFromCustomer() {
		$this->autoRender = false;
		$this->loadModel("User");
		$contactInfo = $this->request["data"]["contactForm"];
		$types = array("Opinion", "Complaint", "Cooperative offer", "Media contact", "Other");
		if (!in_array($contactInfo["messageType"], $types)) {
			$this->redirect("/contact");
		}
		if (!$this->Session->read("loggedIn")) {
			$subject = $contactInfo["messageType"] . " from: " . $contactInfo["from"];
		} else {
			$user = $this->User->find("first", array(
				"conditions" => array(
					"id" => $this->Session->read("userUUID")
				),
				"fields" => array(
					"email"
				)
			));
			$subject = $contactInfo["messageType"] . " from: " . $user["User"]["email"];
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
						\"subject\": \"" . $subject . "\"
					}
				],
				\"from\": {
					\"email\": \"no-reply@alphatech.pl\"
				},
				\"content\": [
					{
						\"type\": \"text/plain\",
						\"value\": \"" . $contactInfo["message"] . "\"
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

	//Function responsible for sending a forgot password email
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
							\"value\": \"http://localhost/Shop/vendor/cakephp/cakephp/update-password-page?id=" .
								$userId . "\"
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

	//Function responsible for replying to users messges
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
								\"email\": \"" . $data["email"] . "\"
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
						\"value\": \"" . $data["message"] . "\"
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

	//Function for sending newsletter
	public function sendNewsletter() {
		$this->loadModel("Product");
		$product = $this->Product->find("first", array("order" => "RAND()"))["Product"];
		$id = $product["id"];
		$name = $product["name"];
		$price = $product["price"];

		$message = "
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}
		</style>
		<div style='width: 100%; height: 100%; float: left;'>
			<div style='width: 100%; height: 50px; background-color: #b0ffb8; margin-bottom: 100px;'>
				<p style='text-align: right; margin-right: 150px; line-height: 50px; font-size: 22px;'>AlphaTech</p>
			</div>
			<div style='margin-top: 100px; margin: auto; width: 500px;
				-webkit-box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.75);
				-moz-box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.75);
				box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.75);'>
				<h1 style='text-align: center; padding: 50px;'>Special offer!</h1>
				<div style='background-color: #fff; width: 400px; margin: auto; margin-bottom: 100px; padding: 10px;'>
				<img src='http://localhost/Shop/vendor/cakephp/cakephp/app/webroot/img/$id.jpg' style='width: 70%;
					margin: auto; display: block'/>
				<h3 style='text-align: center'>$name</h3>
				<p style='text-align: center'>Now only " . (floatval($price) * 0.8) . " USD!</p>
				<p style='text-align: center'>
					<a href='https://twitter.com/AlphaTech0' target='_blank' style='color: black; text-decoration: none'>
						<i class='fab fa-twitter'></i> Twitter
					</a>
					<a href='https://www.instagram.com/0000alphatech0000/' target='_blank' style='color: black;
						text-decoration: none'>
						<i class='fab fa-instagram'></i> Instagram
					</a>
				</p>
			</div>
		</div>
		<div style='width: 100%; height: 50px; background-color: #b0ffb8; text-align: center; line-height: 50px;
			padding-bottom: 10px;'>
			Kamil Waniczek " . date("Y") . " &copy; " . __("all_rights_reserved") .
			" <a href='privacy-policy-and-cookies-" . $this->Session->read("language") . "'>" . __("privacy_policy") .
			"</a>&nbsp;<a href='terms-of-service-" . $this->Session->read("language") . "'>" . __("terms_of_service") .
			"</a>
		</div>
	</div>";

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
						\"subject\": \"Special offer from AlphaTech!\"
					}
				],
				\"from\": {
					\"email\": \"no-reply@alphatech.pl\"
				},
				\"content\": [
					{
						\"type\": \"text/html\",
						\"value\": \"$message\"
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
		debug($response);
		debug($err);
		curl_close($curl);
	}
}
