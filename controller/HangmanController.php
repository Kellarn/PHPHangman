<?php

namespace controller;

class HangmanController {

    private $hangmanView;

    public function __construct(\view\HangmanView $hangmanView){
        $this->hangmanView = $hangmanView;
        
    }
    public function renderHangmanPage(){
    $pageToEcho = $this->hangmanView->show();
    echo $pageToEcho;
    }

}