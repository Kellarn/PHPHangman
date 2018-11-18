<?php

namespace model;

class Login {
    private $link;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

public function sql($username, $password){
    $this->link = $this->dbConnection->connection();

    if(!empty($username) && !empty($password)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($this->link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // var_dump($stmt);
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
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
                            // Redirect user to welcome page
                            // header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            return "Wrong name or password";
                        }
                    }
                } else{
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
}

?>