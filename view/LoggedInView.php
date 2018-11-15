<?php

namespace view;

class LoggedInView {

    private $highScore;
    private $addHangmanWords;
    private $highscores;

    public function __construct(\model\AddHangmanWords $ahw, \model\Highscore $hs) {
        $this->addHangmanWords = $ahw;
        $this->highScore = $hs;
    }

    public function renderLoggedInView() {
        $response = $this->response();
        $highscore = $this->renderPlayerHighscores();
        return '
        '. $response .'
        '. $highscore . '
        ';
    }

    public function response() {
        $message = "";
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])){
            $word = $this->getRequestWord();
            $message = $this->addHangmanWords->addWord($word);
            $response = $this->addWordForm($message);
        } else {
            $response = $this->addWordForm($message);
        }
        return $response;
    }
    private function addWordForm($message) {
        return '
        <form method="post" action="">
           <fieldset>
             <legend>Type in a word to add to collection</legend>
             <p id="message">' . $message . '</p>
             <input type="text" name="word" autofocus />
             <input type="submit" name="add" value="Add" /> 
            </fieldset>
        </form>';
    }

    private function getRequestWord() {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST["word"];
		}
    }

    private function renderPlayerHighscores() {
        $highscores = [];
        if(isset($_SESSION["username"])) {
            $highscores = $this->highScore->getPlayerHighscore($_SESSION["username"]);
         }
        $highscoreTags = '
        <h3>My highscore</h3>
            <ol>
        ';
        foreach($highscores as $highscore) {
            $highscoreTags .= '<li> 
            Solved words: '. $highscore->solvedWords .'
            <br>Amount of failes: '. $highscore->totalAmountOfTries.'
            </li>
            ';
        }
        $highscoreTags .= '</ol>';
        return $highscoreTags;
    }
    private function getHighscores() {
        if(isset($_SESSION["username"])) {
           $highscores = $this->highScore->getPlayerHighscore($_SESSION["username"]);
        }
    }
}