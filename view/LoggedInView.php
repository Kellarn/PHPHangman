<?php

namespace view;

class LoggedInView {

    private $highScore;
    private $addHangmanWords;
    public function __construct(\model\AddHangmanWords $ahw, \model\Highscore $hs) {
        $this->addHangmanWords = $ahw;
        $this->highScore = $hs;
    }



}