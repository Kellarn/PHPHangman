<?php
session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/Login.php');
require_once('controller/LoginController.php');
require_once('view/RegisterView.php');
require_once('model/Register.php');

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

$app = new \controller\LoginController($v, $lv, $dtv, $rv);
$app->renderPage();






