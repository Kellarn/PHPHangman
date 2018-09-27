<?php

namespace controller;

class LoginController {
    
    private $loginView;
    private $layoutView;
    private $loginModel;
    private $dateTimeView;

    public function __construct(\view\LoginView $loginView, \view\LayoutView $layoutView, \view\DateTimeView $dateTimeView){
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        // $this->loginModel = $loginModel;
        $this->dateTimeView = $dateTimeView;
    }

    public function check(){
        $this->layoutView->checkIfUserIsLoggedIn();
    }
    public function renderPage(){
        /* $login = new \model\Login();
//CREATE OBJECTS OF THE VIEWS
$v = new LoginView($login);
$dtv = new DateTimeView();
$lv = new LayoutView();*/

    $this->layoutView->render($this->loginView, $this->dateTimeView);
    }
}