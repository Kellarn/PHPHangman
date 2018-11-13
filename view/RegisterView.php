<?php

namespace view;

class RegisterView {

	private static $UserName = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $repeatPassword = 'RegisterView::PasswordRepeat';
    private static $getUsername = '';
    private static $register = 'RegisterView::Register';
    private static $Message = 'RegisterView::Message';
    private static $userNameValue = '';

    private $registerModel;
    public function __construct(\model\Register $registerModel){
        $this->registerModel = $registerModel;
    }

    public function showRegisterTag(){
        if(isset($_GET["register"])){
            return "<a href='?login'>Back to login</a>";
          } else if(isset($_SESSION["isLoggedIn"])) {
            return "";
          } else {
            return "<a href='?register'>Register a new user</a>";
          }
    }

    public function response(){
        $message = '';

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST[self::$register]){
            self::$userNameValue = $this->getRequestUserName();
            $message = $this->registerModel->addUserToDatabase($this->getRequestUserName(), $this->getRequestPassword(), $this->getRequestRepeatPassword());
            $response = $this->generateRegisterHTML($message);
        } else {
            $response = $this->generateRegisterHTML($message);
        }
        return $response;
    }

    private function generateRegisterHTML($message){
        return '
            <h2>Register new user</h2>
			<form method="post"> 
				<fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$Message . '">' . $message . '</p>

					<label for="' . self::$UserName . '">Username :</label>
					<input type="text" id="' . self::$UserName . '" name="' . self::$UserName . '" value="'. self::$userNameValue . '" />

					<label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    
                    <label for="' . self::$repeatPassword . '">Repeat password :</label>
					<input type="password" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />
					
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
    }

    private function getRequestPassword() {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[self::$password];
		}
    }
    private function getRequestRepeatPassword() {
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[self::$repeatPassword];
		}
	}

	private function getRequestUserName(){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[self::$UserName];
		}
	}
}