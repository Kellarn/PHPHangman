<?php

namespace view;

class LayoutView {
  
  public static $loggedIn = false;
  public function render(LoginView $v, DateTimeView $dtv, RegisterView $rv) {
    $checkResponse =  $this->checkWhichResponseToShow($v, $rv);
    // echo $renderisLoggedIn;
    $show = $dtv->show();
    $renderisLoggedIn = $this->renderIsLoggedIn();
    $registerTag = $rv->showRegisterTag();
    return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' .$registerTag . '
          ' . $renderisLoggedIn . '
          
          <div class="container">
              ' . $checkResponse . '
              
              ' . $show . '
          </div>
         </body>
      </html>
    ';
  }

  /*public function checkIfUserIsLoggedIn(){
    if(isset($_SESSION["isLoggedIn"])){
      self::$loggedIn = $_SESSION["isLoggedIn"];
    }
  }*/
  private function renderIsLoggedIn() {
    if (isset($_SESSION["isLoggedIn"])) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function checkWhichResponseToShow($v, $rv){
    if(isset($_GET["register"])){
      return $rv->response();
    } else {
       return $v->response();
    }
  }
}
