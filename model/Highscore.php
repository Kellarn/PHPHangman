<?php

namespace model;
// Include config file
require_once("environment.php");

class Highscore{
    private static $link;
    private $highscores;


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
    public function addHighscore($playerName, $solvedWords, $totalAmountOfTries) {
        $this->connectToSql();
        $query = "INSERT INTO highscore (playerName, solvedWords, totalAmountOfTries) VALUES (?,?,?)";
        $stmt = mysqli_prepare(self::$link, $query);
        mysqli_stmt_bind_param($stmt, "sss", $param_playerName, $param_solvedWords, $param_totalAmountOfTries);

        $param_playerName = $playerName;
        $param_solvedWords = $solvedWords;
        $param_totalAmountOfTries = $totalAmountOfTries;
        if(mysqli_stmt_execute($stmt)){
            return "Word added";
        } else {
            return "Word already exists, please try with an other one.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close(self::$link);
    }

    public function getAllHighscores() {

            // Prepare a select statement
            $sql = "SELECT * FROM highscores";
            $this->highscores = [];
        
            $result = mysqli_query(self::$link, $sql);
            // $row = mysqli_fetch_row($result, MYSQLI_NUM);
            while($row = mysqli_fetch_assoc($result))
            {
                // var_dump($row["word"]);
                array_push($this->highscores, $row["highscore"]);
            }
            // var_dump($words);
            return $this->highscores;

            mysqli_free_result($result);
        // Close connection
        mysqli_close(self::$link);
    }
}
