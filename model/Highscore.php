<?php

namespace model;

class Highscore{

    private $link;
    private $highscores;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

      /**
	 * Connects to DB using DB model and adds a highscore entry based on the player name, 
	 * amount of solved words and the amount of tries. 
     * 
	 * Is called when the game has ended and the player has lost or won the whole game. 
	 *
	 * @return bool to show if it worked or not. 
     * @param playerName name of the current logged in player
     * @param solvedWords amount of solved words
     * @param totalAmountOfTries total amount of tries during the whole game
    **/
    public function addHighscore($playerName, $solvedWords, $totalAmountOfTries){
        $this->link = $this->dbConnection->connection();

        $query = "INSERT INTO highscore (playerName, solvedWords, totalAmountOfTries) VALUES (?,?,?)";

        $stmt = mysqli_prepare($this->link, $query);
        mysqli_stmt_bind_param($stmt, "sss", $param_playerName, $param_solvedWords, $param_totalAmountOfTries);

        $param_playerName = $playerName;
        $param_solvedWords = $solvedWords;
        $param_totalAmountOfTries = $totalAmountOfTries;


        if(mysqli_stmt_execute($stmt)){
            return true;
        } else {
            return false;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($this->link);
    }

    /**
	 * Connects to DB using DB model and recives the top 3 highscores for the current
     * logged in player.
     * 
	 * Is called when the the logged in user goes to his page. 
	 *
	 * @return array containing all higshcore entries for the current logged in player.
     * @param username name of the player to recieve the highscores from
	 **/
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
