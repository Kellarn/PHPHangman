<?php

namespace view;

class MainLayoutView {

    private $hangmanController;
    private $loginController;

    public function __construct(\controller\HangmanController $hangmanController, \controller\LoginController $loginController)
    {
        $this->hangmanController = $hangmanController;
        $this->loginController = $loginController;
    }
  
  public function render() {
    $loginLayoutView = $this->loginController->renderPage();
    // $dateTimeView = $dtv->show();
    $hangmanView = $this->hangmanController->renderHangmanPage();
    return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Workshop 3</title>
        </head>
        <body>
          <h1>Lets play Hangman!</h1>
          <div class="game">
          '.$hangmanView.'
          </div>
          '.$loginLayoutView.'
         </body>
      </html>
    ';
  }
}
