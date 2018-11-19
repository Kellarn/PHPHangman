<?php

namespace Model;

require_once("environment.php");

class Register{

    private $link;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

    /**
	 * Connects to DB using DB model adds the user to the DB.
     * Params are validated before sent to this function. 
     * 
	 * Is called when a user wants to register his user to be able to log in. 
	 *
	 * @return string message to display if the user could be added or not.
     * @param username name of the user to log in.
     * @param password password of the user to log in
	 */

    public function addUserToDatabase($userName, $password){

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

    /**
     * Small function to teturn the status of the session variable isLoggedIn
     */
    public function isUserLoggedIn() {

        return isset($_SESSION["isLoggedIn"]);
    }
}