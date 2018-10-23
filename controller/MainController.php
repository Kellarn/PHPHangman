<?php

namespace controller;

class MainController {
    
    private $loginController;
    private $hangmanController;

    public function __construct(\controller\LoginController $loginController, \controller\HangmanController $hangmanController){
        $this->loginController = $loginController;
        $this->hangmanController = $hangmanController;

    }
    public function renderMainPage(){
    $this->hangmanController->renderHangmanPage();
    $this->loginController->renderPage();
    }

}