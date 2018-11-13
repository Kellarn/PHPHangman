<?php

namespace view;

class MainLayoutView {

    private $hangmanController;
    private $loginController;
    private $loginLayoutView;
    private $hangmanView;

    public function __construct(\controller\HangmanController $hangmanController, \controller\LoginController $loginController)
    {
        $this->hangmanController = $hangmanController;
        $this->loginController = $loginController;
        $_SESSION = [];
    }
  
  public function render() {
    // $dateTimeView = $dtv->show();
    $this->checkWhatLoginToShow();
    // $hangmanView = $this->hangmanController->renderHangmanPage();
    return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Workshop 3</title>
        </head>
        <body>
          <h1>Lets play Hangman!</h1>
          <div class="game">
          '.$this->hangmanView.'
          </div>
          '.$this->loginLayoutView.'
         </body>
      </html>
    ';
  }

  private function checkWhatLoginToShow() {
    if(isset($_POST["goToLogin"])) {
        $this->loginLayoutView = $this->loginController->renderPage();
        $this->hangmanView = "";
    } else if(isset($_GET["register"]) || isset($_GET["login"])) {
        $this->loginLayoutView = $this->loginController->renderPage();
        $this->hangmanView = "";
    } else {
        $this->hangmanView = $this->hangmanController->renderHangmanPage();
        $this->loginLayoutView = $this->loginController->renderGoToLogin();
    }
  }
}
