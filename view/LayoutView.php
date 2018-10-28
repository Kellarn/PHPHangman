<?php

namespace view;

class LayoutView {
  
  public static $loggedIn = false;
  public function render(LoginView $v, DateTimeView $dtv, RegisterView $rv) {
    $checkResponse =  $this->checkWhichResponseToShow($v, $rv);
    $show = $dtv->show();
    $renderisLoggedIn = $this->renderIsLoggedIn();
    $registerTag = $rv->showRegisterTag();
    return'
          ' .$registerTag . '
          ' . $renderisLoggedIn . '
          
          <div class="container">
              ' . $checkResponse . '
              
              ' . $show . '
          </div>
    ';
  }

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
