<?php

namespace model;
// Include config file
require_once("environment.php");

class AddHangmanWords {
    private static $link;
    private $words;


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
    public function addWord($word) {
        $this->connectToSql();
        $query = "INSERT INTO words (word) VALUES (?)";
        $stmt = mysqli_prepare(self::$link, $query);
        mysqli_stmt_bind_param($stmt, "s", $param_word);

        $param_word = $word;
        if(mysqli_stmt_execute($stmt)){
            //$_SESSION["newUsername"] = $userName;
            //$_SESSION["message"] = "Registered new user.";
            return "Word added";
        } else {
            return "Word already exists, please try with an other one.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close(self::$link);
    }
}
