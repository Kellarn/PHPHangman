<?php

namespace model;

class Highscore{

    private $link;
    private $highscores;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

    public function addHighscore($playerName, $solvedWords, $totalAmountOfTries){
        $this->link = $this->dbConnection->connection();

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
        mysqli_close($this->link);
    }

    public function getPlayerHighscore($username){
        $this->highscores = [];
        $this->link = $this->dbConnection->connection();

        // Prepare a select statement
        $sql = "SELECT * FROM highscore WHERE playerName = '$username' ORDER BY solvedWords DESC, totalAmountOfTries LIMIT 3";
        $result = mysqli_query($this->link, $sql);

        while($obj = mysqli_fetch_object($result))
        {
            array_push($this->highscores, $obj);
        }

        mysqli_free_result($result);
        mysqli_close($this->link);

        return $this->highscores;
    }
}
