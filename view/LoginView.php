<?php

// require_once("model/login.php");
namespace view;


class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private static $getUsername = '';

	private $loginModel;

	public function __construct(\model\login $loginModel){
		$this->loginModel = $loginModel;
	}

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		// $LoginModel = new LoginModel();
		// echo $this->loginModel->sendMessage();
		$message = '';

		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST[self::$logout])){
				session_destroy();
				$_SESSION = [];
				$message = "Bye bye!";
				$response = $this->generateLoginFormHTML($message);
				// return $response;
			} else {
				$username = $this->postRequestUserName();
		        $password = $this->getRequestPassword();
				self::$getUsername = $this->postRequestUserName();
			    if(empty($username)) {
					$message = "Username is missing";
					$response = $this->generateLoginFormHTML($message);
			    } else if(empty($password)){
					$message = "Password is missing";
					$response = $this->generateLoginFormHTML($message);
			    } else {
				   $message = $this->loginModel->sql($this->postRequestUserName(), $this->getRequestPassword());
				   $response = $this->generateLoginFormHTML($message);
				   if(isset($_SESSION["isLoggedIn"])){
					$response = $this->generateLogoutButtonHTML($message);
				   }
			    }
			}
		} else {
			$response = $this->generateLoginFormHTML($message);
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
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
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
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. self::$getUsername . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
			if(isset($_GET[self::$name])){
				return $_GET[self::$name];
			}
		//RETURN REQUEST VARIABLE: USERNAME
	}

	private function getRequestPassword() {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[self::$password];
		}
	}

	private function postRequestUserName(){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[self::$name];
		}
	}
	
}