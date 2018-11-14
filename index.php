<?php
session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/Login.php');
require_once('controller/LoginController.php');
require_once('controller/MainController.php');
require_once('controller/HangmanController.php');
require_once('view/RegisterView.php');
require_once('model/Register.php');
require_once('view/HangmanView.php');
require_once('model/HangmanStates.php');
require_once('model/GetHangmanWords.php');
require_once('view/MainLayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//Creat objects of the models
$login = new \model\Login();
$register = new \model\Register();
$hs = new \model\HangmanStates();
$hw = new \model\GetHangmanWords();

//CREATE OBJECTS OF THE VIEWS
$v = new \view\LoginView($login);
$dtv = new \view\DateTimeView();
$rv = new \view\RegisterView($register);
$lv = new \view\LayoutView($v, $dtv, $rv);
$hv = new \view\HangmanView($hs, $hw);


//Create objects of the controllers
$loginController = new \controller\LoginController($v, $lv, $dtv, $rv);
$hangmanController = new \controller\HangmanController($hv);

$mlv = new \view\MainLayoutView($hangmanController, $loginController);
$mainController = new \controller\MainController($mlv);

//Render main page using the main controller
$mainController->renderMainPage();






