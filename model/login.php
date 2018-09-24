<?php

namespace Model;
// Include config file
// require_once "config.php";

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'lab2');
 

class Login {
    private static $link;

    public function __construct(){
        self::$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
 
private function connectToSql() {

// Check connection
    if(self::$link === false){
       die("ERROR: Could not connect. " . mysqli_connect_error());
    } else {
       return "Connection successfull";
    }
}

public function sendMessage(){
    return $this->connectToSql();
}
public function sql($username, $password) {
    // Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    /* if(empty(trim($_POST[$username]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    */
    // Validate credentials
    if(!empty($username) && !empty($password)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        // var_dump($sql);
        if($stmt = mysqli_prepare(self::$link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // var_dump($stmt);
            // Set parameters
            $param_username = $username;
            echo $param_username;
            
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
                            // session_destroy();
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["isLoggedIn"] = true;
                            // $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            // header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            return "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    return "No account found with that username.";
                }
            } else{
                return "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close(self::$link);
}
}
}

?>