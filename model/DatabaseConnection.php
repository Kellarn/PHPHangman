<?php

namespace model;

require_once("environment.php");

class DatabaseConnection {

    private static $link;

    public function __construct(){
        self::$link = mysqli_connect($_ENV["DB_SERVER"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
    }
    
    public function connection() {
        if(self::$link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        } else {
            return self::$link;
        }
    }
}