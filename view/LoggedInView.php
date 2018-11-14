<?php

namespace view;

class LoggedInView {

    private $highScore;
    private $addHangmanWords;
    public function __construct(\model\AddHangmanWords $ahw, \model\Highscore $hs) {
        $this->addHangmanWords = $ahw;
        $this->highScore = $hs;
    }

    private function renderLoggedInView() {
        return '
        '. $this->addWordForm() .'
        ';
    }

    public function response() {
        $message = "";
        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["add"]){
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
}