<?php

namespace view;

class LayoutView {
  

  private $LoginView;
  private $DateTimeView;
  private $RegisterView;
  private $LoggedInView;

  private $registerTag;
  private $registerOrLogin;
  private $dateTime;
  private $loggedInOrNotTag;
  private $backButton;
  private $addWord;

  public function __construct(\view\LoginView $v, \view\DateTimeView $dtv, \view\RegisterView $rv, \view\LoggedInView $liv) {
    $this->LoginView = $v;
    $this->DateTimeView = $dtv;
    $this->RegisterView = $rv;
    $this->LoggedInView = $liv;
  }
  
  public function render() {

    $this->checkWhatToRender();

    return'
          ' .$this->registerTag . '
          ' . $this->loggedInOrNotTag . '
          ' . $this->addWord . '
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

  private function checkWhichResponseToShow() {

    if(isset($_GET["login?register"])) {

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
      $this->addWord = $this->LoggedInView->renderLoggedInView();
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
