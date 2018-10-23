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

//var_dump($_SESSION["isLoggedIn"]);

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$login = new \model\Login();
$register = new \model\Register();
//CREATE OBJECTS OF THE VIEWS
$v = new \view\LoginView($login);
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();
$rv = new \view\RegisterView($register);
$hs = new \model\HangmanStates();
$hw = new \model\GetHangmanWords();
$hv = new \view\HangmanView($hs, $hw);

$loginController = new \controller\LoginController($v, $lv, $dtv, $rv);
$hangmanController = new \controller\HangmanController($hv);
$mainController = new \controller\MainController($loginController, $hangmanController);
$mainController->renderMainPage();






