<?php

namespace controller;

class HangmanController {

    private $hangmanView;

    public function __construct(\view\HangmanView $hangmanView){
        $this->hangmanView = $hangmanView;
        
    }
    public function initHangmanGame() {
        $this->hangmanView->initGame();
    }
    public function renderHangmanPage(){
    $pageToEcho = $this->hangmanView->checkTheGame();
    return $pageToEcho;
    }

}