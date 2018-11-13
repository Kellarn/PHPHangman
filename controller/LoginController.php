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
    $pageToEcho = $this->layoutView->render($this->loginView, $this->dateTimeView, $this->registerView);
    return $pageToEcho;
    }

    public function renderGoToLogin() {
        $pageToEcho = $this->loginView->renderGoToLogin();
        return $pageToEcho;
    }

}