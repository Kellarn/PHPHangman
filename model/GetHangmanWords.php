<?php

namespace model;
// Include config file
require_once("environment.php");



// session_start();

class GetHangmanWords {
    private $link;
    private $words;
    private $config;


    public function __construct(\model\DatabaseConnection $$dbc){
        // self::$link = mysqli_connect($_ENV["DB_SERVER"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
        $this->config = $config;
    }
 
    public function sql() {
        $this->link = $this->config->connection();
        // Prepare a select statement
        $sql = "SELECT * FROM words";
        $this->words = [];
        
        $result = mysqli_query($this->link, $sql);
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($this->words, $row["word"]);
        }
        return $this->words;

            mysqli_free_result($result);
        // Close connection
        mysqli_close($this->link);
    }

    public function setCurrentGameWord()
    {
        $this->sql();
        $amountOfWords = count($this->words);
        $randomNumber = rand(0, $amountOfWords -1);
        $randomWord = $this->words[$randomNumber];
        $len = strlen($randomWord);
        $theWordtoGuess = str_repeat('_ ', $len);
        return $theWordtoGuess;
    }
}
