<?php

namespace Model;
// Include config file
require_once("environment.php");



// session_start();

class GetHangmanWords {
    private static $link;
    private $words;


    public function __construct(){
        self::$link = mysqli_connect($_ENV["DB_SERVER"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
        $this->connectToSql();
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
            $this->words = [];
        
            $result = mysqli_query(self::$link, $sql);
            // $row = mysqli_fetch_row($result, MYSQLI_NUM);
            while($row = mysqli_fetch_assoc($result))
            {
                // var_dump($row["word"]);
                array_push($this->words, $row["word"]);
            }
            // var_dump($words);
            return $this->words;

            mysqli_free_result($result);
        // Close connection
        mysqli_close(self::$link);
    }

    public function setCurrentGameWord()
    {
        $amountOfWords = count($this->words);
        $randomNumber = rand(0, $amountOfWords -1);
        var_dump($amountOfWords);
        $randomWord = $this->words[$randomNumber];
        $len = strlen($randomWord);
        $theWordtoGuess = str_repeat('_ ', $len);
        return $theWordtoGuess;
    }
}
