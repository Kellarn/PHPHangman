<?php

namespace model;

class AddHangmanWords {

    private $link;
    private $words;
    private $dbConnection;

    public function __construct(\model\DatabaseConnection $dbc){
        $this->dbConnection = $dbc;
    }

    /**
	 * Connects to DB using DB model and adds provided param word to DB.
	 *
	 * Should be called when a input is correct after checking in loggedinView.
	 *
	 * @return  string to be displayed from view.
     * @param word the word to be added to DB.
	 */
    public function addWord($word) {
        $this->link = $this->dbConnection->connection();

        $query = "INSERT INTO words (word) VALUES (?)";
        $stmt = mysqli_prepare($this->link, $query);

        mysqli_stmt_bind_param($stmt, "s", $param_word);
        $param_word = $word;

        if(mysqli_stmt_execute($stmt)){
            return "Word added";
        } else {
            return "Word already exists, please try with an other one.";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($this->link);
    }
}
