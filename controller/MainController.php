<?php

namespace controller;

class MainController {
    
    private $loginController;
    private $hangmanController;
    private $mainLayoutView;
    private $dateTimeView;
    private $hangmanView;
    private $layoutView;
    private $registerView;
    private $loginView;

    public function __construct(\view\MainLayoutView $mainLayoutView){
        $this->mainLayoutView = $mainLayoutView;
    }
    public function renderMainPage(){
    // echo $this->mainLayoutView->render($this->layoutView, $this->dateTimeView, $this->hangmanView, $this->registerView, $this->loginView);
    // $this->loginController->renderPage();
    echo $this->mainLayoutView->render();
    }

}