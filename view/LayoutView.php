<?php

namespace view;

class LayoutView {
  
  public static $loggedIn = false;
  public function render(LoginView $v, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn(self::$loggedIn) . '
          
          <div class="container">
              ' . $v->response() . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  public function checkIfUserIsLoggedIn(){
    if(isset($_SESSION["isLoggedIn"])){
      self::$loggedIn = $_SESSION["isLoggedIn"];
    }
  }
  private function renderIsLoggedIn($loggedIn) {
    if ($loggedIn == true) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
