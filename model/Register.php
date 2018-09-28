<?php

namespace Model;

require_once("environment.php");

class Register{

    private static $link;

    public function __construct(){
        self::$link = mysqli_connect($_ENV["DB_SERVER"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    }

    private function connectToSql() {

        // Check connection
            if(self::$link === false){
               die("ERROR: Could not connect. " . mysqli_connect_error());
            } else {
               return "Connection successfull";
            }
    }

    public function addUserToDatabase($userName, $password, $repeatPassword){
        $this->connectToSql();

        if(empty($userName) || empty($password) || empty($repeatPassword)){
            return "Password has too few characters, at least 6 characters.";
        } else if(trim(strlen($userName)) < 3) {
            return "Username has too few characters, at least 3 characters.";
        } else if(trim(strlen($password)) < 6) {
            return "Password has too few characters, at least 6 characters.";
        } else if($password != $repeatPassword){
            return "Passwords do not match.";
        }
    }
}