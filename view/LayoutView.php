<?php

namespace view;

class LayoutView {
  

  private $LoginView;
  private $DateTimeView;
  private $RegisterView;

  private $registerTag;
  private $registerOrLogin;
  private $dateTime;
  private $loggedInOrNotTag;
  private $backButton;

  public function __construct(\view\LoginView $v, \view\DateTimeView $dtv, \view\RegisterView $rv) {
    $this->LoginView = $v;
    $this->DateTimeView = $dtv;
    $this->RegisterView = $rv;
  }
  
  public function render() {
    $this->checkWhatToRender();
    return'
          ' .$this->registerTag . '
          ' . $this->loggedInOrNotTag . '
          
          <div class="container">
              ' . $this->registerOrLogin . '
              
              ' . $this->dateTime . '
          </div>
          ' . $this->backButton . '
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

  private function checkWhichResponseToShow(){
    if(isset($_GET["register"])){
      return $this->RegisterView->response();
    } else {
       return $this->LoginView->response();
    }
  }

  private function checkWhatToRender() {
    $this->registerOrLogin =  $this->checkWhichResponseToShow();
    $this->dateTime = $this->DateTimeView->show();
    $this->loggedInOrNotTag = $this->renderIsLoggedIn();
    
    if(isset($_GET["login"])) {
      $this->registerTag = $this->RegisterView->showRegisterTag();
      $this->backButton = $this->renderBackButton();
    } else {
      $this->registerTag = "";
      $this->backButton = "";
    }
  }

  private function renderBackButton() {
    return '
    <form method="post" action="?">
			<input type="submit" name="goToHangman" value="Back"/>
		</form>';
  }
}
