<?php

namespace view;

class LoggedInView {

    private $highScore;
    private $addHangmanWords;
    private $highscores;
    private $add;
    private $word;

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
        $response = "";
        
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$this->add])) {

            $word = $this->getRequestWord();
            $message = $this->addHangmanWords->addWord($word);
            $response = $this->addWordForm($message);
        } else {

            if(isset($_SESSION["isLoggedIn"])) {

                $response = $this->addWordForm($message);
            }
        }
        return $response;
    }
    private function addWordForm($message) {

        return '
        <form method="post" action="">
           <fieldset>
             <legend>Type in a word to add to collection</legend>
             <p id="message">' . $message . '</p>
             <input type="text" name="'. $this->word .'" autofocus />
             <input type="submit" name="'. $this->add .'" value="Add" /> 
            </fieldset>
        </form>';
    }

    private function getRequestWord() {

        if($_SERVER["REQUEST_METHOD"] == "POST"){
			return $_POST[$this->word];
		}
    }

    private function renderPlayerHighscores() {

        if(isset($_SESSION["isLoggedIn"])) {

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
        } else {

            return "";
        }
    }
    private function getHighscores() {

        if(isset($_SESSION["username"])) {
           $highscores = $this->highScore->getPlayerHighscore($_SESSION["username"]);
        }
    }
}