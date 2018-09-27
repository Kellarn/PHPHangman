<?php

namespace controller;

class LoginController {
    
    private $loginView;
    private $layoutView;
    private $loginModel;
    private $dateTimeView;
    private $registerView;

    public function __construct(\view\LoginView $loginView, \view\LayoutView $layoutView, \view\DateTimeView $dateTimeView, \view\RegisterView $registerView){
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        // $this->loginModel = $loginModel;
        $this->dateTimeView = $dateTimeView;
        $this->registerView = $registerView;
    }
    public function renderPage(){
        /* $login = new \model\Login();
//CREATE OBJECTS OF THE VIEWS
$v = new LoginView($login);
$dtv = new DateTimeView();
$lv = new LayoutView();*/
    $pageToEcho = $this->layoutView->render($this->loginView, $this->dateTimeView, $this->registerView);
    echo $pageToEcho;
    }

}