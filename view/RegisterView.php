<?php

namespace view;

class RegisterView {

	private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $repeatPassword = 'RegisterView::PasswordRepeat';
    private static $getUsername = '';
    private static $register = 'RegisterView::Register';

    public function showRegisterTag(){
        if(isset($_GET["register"])){
            return "<a href='?index'>Back to login</a>";
          } else if(isset($_SESSION["isLoggedIn"])) {
            return "";
          } else {
            return "<a href='?register'>Register a new user</a>";
          }
    }

    public function test() {
        return "TEst";
    }

    public function generateRegisterHTML(){
        return '
            <h2>Register new user</h2>
			<form method="post" action="index.php"> 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. self::$getUsername . '" />

					<label for="' . self::$password . '">Password :</label>
                    <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                    
                    <label for="' . self::$repeatPassword . '">Password :</label>
					<input type="password" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />
					
					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
    }
}