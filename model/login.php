<?php

namespace model;

class Login {
    private $link;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

    /**
	 * Connects to DB using DB model and checks if the user exists in the DB,
     * and therefore being able to "log" him in.
     * 
	 * Is called when a user enters a username and password that passes validation.
	 *
	 * @return string message to display if the user could be found or not or if anything else happend.
     * @param username name of the user to log in.
     * @param password password of the user to log in.
	 */
    public function loginUser($username, $password){
    $this->link = $this->dbConnection->connection();

        if(!empty($username) && !empty($password)){
            // Prepare a select statement
            $sql = "SELECT username, password FROM users WHERE username = ?";
        
            if($stmt = mysqli_prepare($this->link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                // Set parameters
                $param_username = $username;
            
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1){                
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){

                            if($password == $hashed_password){
                            
                                session_destroy();
                                // Password is correct, so start a new session
                                session_start();

                                // Store data in session variables
                                $_SESSION["isLoggedIn"] = true;
                                $_SESSION["username"] = $username;

                                return "Welcome";
                            } else {

                                // Display an error message if password is not valid
                                return "Wrong name or password";
                            }
                        }
                    } else {
                        // Display an error message if username doesn't exist
                        return "Wrong name or password";
                    }
                } else{
                    return "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($this->link);
    }

    /**
     * Short function to return if user is logged in or not.
     */
    public function isUserLoggedIn() {
        
        return isset($_SESSION["isLoggedIn"]);
    }
}

?>