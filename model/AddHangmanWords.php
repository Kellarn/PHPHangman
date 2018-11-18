<?php

namespace model;

class AddHangmanWords {

    private $link;
    private $words;
    private $config;

    public function __construct(\model\DatabaseConnection $$dbc){
        $this->config = $config;
    }
 
    public function addWord($word) {
        $this->link = $this->config->connection();
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
