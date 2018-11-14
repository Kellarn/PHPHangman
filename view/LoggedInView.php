<?php

namespace view;

class LoggedInView {

    private $highScore;
    private $addHangmanWords;
    public function __construct(\model\AddHangmanWords $ahw, \model\Highscore $hs) {
        $this->addHangmanWords = $ahw;
        $this->highScore = $hs;
    }

    public function renderLoggedInView() {
        return '
        '. $this->addWordForm() .'
        ';
    }

    private function addWordForm() {
        return '
        <form method="post" action="">
           <fieldset>
             <legend>Type in a word to add to collection</legend>
             <input type="text" name="word" autofocus />
             <input type="submit" name="add" value="Add" /> 
            </fieldset>
        </form>';
    }
}