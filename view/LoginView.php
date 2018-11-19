<?php

// require_once("model/login.php");
namespace view;


class LoginView {
	private $loginModel;

	private $login = 'LoginView::Login';
	private $logout = 'LoginView::Logout';
	private $name = 'LoginView::UserName';
	private $password = 'LoginView::Password';
	private $cookieName = 'LoginView::CookieName';
	private $cookiePassword = 'LoginView::CookiePassword';
	private $keep = 'LoginView::KeepMeLoggedIn';
	private $messageId = 'LoginView::Message';

	private $getUsername = '';

	public function __construct(\model\login $loginModel){
		$this->loginModel = $loginModel;
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response() {

		$message = '';

		if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$this->login]) || isset($_POST[$this->logout]) ) {

			if(isset($_POST[$this->logout])) {

				session_destroy();
				$_SESSION = [];

				$message = "Bye bye!";
				$response = $this->generateLoginFormHTML($message);
			} else {
				
				$username = $this->postRequestUsername();
				$password = $this->postRequestPassword();
				$this->getUsername = $this->postRequestUserName();
			    if(empty($username)) {

					$message = "Username is missing";
					$response = $this->generateLoginFormHTML($message);
			    } else if(empty($password)) {

					$message = "Password is missing";
					$response = $this->generateLoginFormHTML($message);
			    } else {

				   $message = $this->loginModel->loginUser($this->postRequestUsername(), $this->postRequestPassword());
				   $response = $this->generateLoginFormHTML($message);
				   if($this->loginModel->isUserLoggedIn()) {

					$response = $this->generateLogoutButtonHTML($message);
				   }
			    }
			}
		} else {
			if(isset($_GET["login"])) {

				if($this->loginModel->isUserLoggedIn()) {

					$response = $this->generateLogoutButtonHTML($message);
				} else {
					   
					$response = $this->generateLoginFormHTML($message);
				}
			} else {

				$response = $this->renderGoToLogin();
			}
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . $this->messageId . '">' . $message .'</p>
				<input type="submit" name="' . $this->logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post"> 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . $this->messageId . '">' . $message . '</p>
					
					<label for="' . $this->name . '">Username :</label>
					<input type="text" id="' . $this->name . '" name="' . $this->name . '" value="' . $this->getUsername .'"/>

					<label for="' . $this->password . '">Password :</label>
					<input type="password" id="' . $this->password . '" name="' . $this->password . '" />

					<label for="' . $this->keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . $this->keep . '" name="' . $this->keep . '" />
					
					<input type="submit" name="' . $this->login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	private function postRequestPassword() {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[$this->password];
		}
	}

	private function postRequestUsername(){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[$this->name];
		}
	}
	
	public function renderGoToLogin() {
		if($this->loginModel->isUserLoggedIn()) {

			return 
			'
			<form method="post" action="?login">
				<input type="submit" name="goToLogin" value="MyPage"/>
			</form>
			';
		} else {

			return 
			'
			<form method="post" action="?login">
				<input type="submit" name="goToLogin" value="Login"/>
			</form>
			';
		}
	}
}