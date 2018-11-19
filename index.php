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
require_once('view/LoggedInView.php');
require_once('model/AddHangmanWords.php');
require_once('model/Highscore.php');
require_once('model/DatabaseConnection.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'OFF');

//Create objects of the models
$dbc = new \model\DatabaseConnection();
$login = new \model\Login($dbc);
$register = new \model\Register($dbc);
$hs = new \model\HangmanStates();
$hw = new \model\GetHangmanWords($dbc);
$ahw = new \model\AddHangmanWords($dbc);
$high = new \model\Highscore($dbc);

//CREATE OBJECTS OF THE VIEWS
$v = new \view\LoginView($login);
$dtv = new \view\DateTimeView();
$rv = new \view\RegisterView($register);
$liv = new \view\LoggedInView($ahw, $high);
$lv = new \view\LayoutView($v, $dtv, $rv, $liv);
$hv = new \view\HangmanView($hs, $hw, $high);


//Create objects of the controllers
$loginController = new \controller\LoginController($lv);
$hangmanController = new \controller\HangmanController($hv);

$mlv = new \view\MainLayoutView($hangmanController, $loginController);
$mainController = new \controller\MainController($mlv);

//Render main page using the main controller
$mainController->renderMainPage();






