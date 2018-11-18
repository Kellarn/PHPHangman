<?php

namespace Model;

require_once("environment.php");

class Register{

    private $link;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

    public function addUserToDatabase($userName, $password, $repeatPassword){

        $this->link = $this->dbConnection->connection();

        if(empty($userName) && empty($password) && empty($repeatPassword)){
            return "Username has too few characters, at least 3 characters.";
        } else if(empty($userName) || empty($password) || empty($repeatPassword)){
            return "Password has too few characters, at least 6 characters.";
        } else if(trim(strlen($userName)) < 3) {
            return "Username has too few characters, at least 3 characters.";
        } else if(!(strip_tags($userName) == $userName)){
            return "Username contains invalid characters.";
        } else if(trim(strlen($password)) < 6) {
            return "Password has too few characters, at least 6 characters.";
        } else if($password != $repeatPassword){
            return "Passwords do not match.";
        } else {

            $query = "INSERT INTO users (username, password) VALUES (?,?)";
            $stmt = mysqli_prepare($this->link, $query);
            mysqli_stmt_bind_param($stmt, "ss", $param_userName, $param_password);

            $param_password = $password;
            $param_userName = $userName;
            
            if(mysqli_stmt_execute($stmt)){
                return "Registered new user.";
            } else {
                return "User exists, pick another username.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($this->link);
        }
    }
}