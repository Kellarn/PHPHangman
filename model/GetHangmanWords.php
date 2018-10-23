<?php

namespace Model;
// Include config file
require_once("environment.php");



// session_start();

class GetHangmanWords {
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

public function sendMessage(){
    return $this->connectToSql();
}
public function sql() {
 
        // Prepare a select statement
        $sql = "SELECT * FROM words";
        $words = [];
        
        $result = mysqli_query(self::$link, $sql);
        // $row = mysqli_fetch_row($result, MYSQLI_NUM);
        while($row = mysqli_fetch_assoc($result))
        {
            // var_dump($row["word"]);
            array_push($words, $row["word"]);
        }
        // var_dump($words);
        return $words;

        mysqli_free_result($result);
    // Close connection
    mysqli_close(self::$link);
}
}
