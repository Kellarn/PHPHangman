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