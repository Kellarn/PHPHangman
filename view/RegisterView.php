<?php

namespace view;

class RegisterView {
    private $registerModel;

	private $username = 'RegisterView::UserName';
    private $password = 'RegisterView::Password';
    private $repeatPassword = 'RegisterView::PasswordRepeat';
    private $register = 'RegisterView::Register';
    private $message = 'RegisterView::Message';

    private $usernameValue = '';
    private $inputIsCorrect = false;

    public function __construct(\model\Register $registerModel){
        $this->registerModel = $registerModel;
    }

      public function response(){
        $message = '';

        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST[$this->register]) {

            $this->usernameValue = $this->postRequestUserName();
            $message = "";
            $this->checkRegisterInput();

            if(!$this->inputIsCorrect) {
                
                $message = $this->checkRegisterInput();
            } else {

                $message = $this->registerModel->addUserToDatabase($this->postRequestusername(), $this->postRequestPassword());
            }

            $response = $this->generateRegisterHTML($message);
        } else {

            $response = $this->generateRegisterHTML($message);
        }

        return $response;
    }

    private function checkRegisterInput() {
        $username = $this->postRequestUsername();
        $password = $this->postRequestPassword();
        $repeatPassword = $this->postRequestRepeatPassword();

        if(empty($username) && empty($password) && empty($repeatPassword)) {

            return "Username has too few characters, at least 3 characters.";
        } else if(empty($username) || empty($password) || empty($repeatPassword)) {

            return "Password has too few characters, at least 6 characters.";
        } else if(trim(strlen($username)) < 3) {

            return "Username has too few characters, at least 3 characters.";
        } else if(!(strip_tags($username) == $username)) 
        {
            return "username contains invalid characters.";
        } else if(trim(strlen($password)) < 6) {

            return "Password has too few characters, at least 6 characters.";
        } else if($password != $repeatPassword) {

            return "Passwords do not match.";
        }

        $this->inputIsCorrect = true;
    }

    private function postRequestUsername(){

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			return $_POST[$this->username];
		}
    }
    
    private function postRequestPassword() {

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			return $_POST[$this->password];
		}
    }

    private function postRequestRepeatPassword() {

		if($_SERVER["REQUEST_METHOD"] == "POST") {

			return $_POST[$this->repeatPassword];
		}
    }
    
    private function generateRegisterHTML($message) {

        return '
            <h2>Register new user</h2>
            <a href="?login">Back to login</a>
			<form method="post"> 
				<fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . $this->message . '">' . $message . '</p>

					<label for="' . $this->username . '">username :</label>
					<input type="text" id="' . $this->username . '" name="' . $this->username . '" value="'. $this->usernameValue . '" />

					<label for="' . $this->password . '">Password :</label>
                    <input type="password" id="' . $this->password . '" name="' . $this->password . '" />
                    
                    <label for="' . $this->repeatPassword . '">Repeat password :</label>
					<input type="password" id="' . $this->repeatPassword . '" name="' . $this->repeatPassword . '" />
					
					<input type="submit" name="' . $this->register . '" value="Register" />
				</fieldset>
			</form>
		';
    }

    public function showRegisterTag() {

        if(isset($_GET["register"])) {
            
            return "<a href='?login'>Back to login</a>";
          } else if($this->registerModel->isUserLoggedIn()) {
            
            return "";
          } else {
            
            return "<a href='?login?register'>Register a new user</a>";
          }
    }
}