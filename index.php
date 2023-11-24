<?php

error_reporting(E_ALL);
session_start();

//-------------------------------------------//
// -------- L O C A L - T E S T S ---------- //
//-------------------------------------------//
define("BASEURL", "/blog");

//-----------------------------------------//
// -------- W E B - S E R V E R ---------- //
//-----------------------------------------//
//define("BASEURL", "http://localhost");
//define("USERNAME", "siatidb");
//define("PASSWORD", 'Sy$t3m86%Sut1n');
// Título da Página
define("PAGE_TITLE", "Agenda de Digital");

//configuração do banco de dados
define("DRIVER", "mysql");
define("HOST", "localhost");
define("CHARSET", "utf8");
//define("CHARSET", "utf8mb4");
define("DATABASE", "aulas");
define("USERNAME", "root");
define("PASSWORD", '');

//configuração da sessão
define('authTable', 'users');
define('authFieldUsername', "username,email,CPF");
define('authFieldPassword', 'password');
define('authLogoutRedirectNickname', 'login');
define('authMessageLogout', 'Olá <strong>%s</strong>, sua sessão foi encerrada!<br>Obrigado por usar os nossos serviços.');
define('authMessageAccessDenied', 'Acesso negado! Entre em contato com o administrador.');
define('authMessageInvalidPassword', "Ops, sua senha está incorreta!<br>Verifique e tente novamente.");
define('authMessageInvalidStatus', "Usuário desativado, entre em contato com o administrador!");

$base_url = rtrim($_SERVER["REQUEST_URI"], "/");

if (strpos($base_url, "index.php")) {
    $base_url = str_replace("index.php", "", $base_url);
    header("Location: " . $base_url);
}

$url = str_replace($base_url, "", $_GET["url"]);

$_controller = "welcome";
$_pathController = "pages";
$_action = "index";
$_params = [];

if (strlen($url) != 0) {
    $_strurl = explode("/", $url);
    if (isset($_strurl[0]) && $_strurl[0] != "") {
        $_controller = $_strurl[0];
        $_pathController = $_strurl[0];
    }
    if (isset($_strurl[1]) && $_strurl[1] != "") {
        $_action = $_strurl[1];
    }
    if (isset($_strurl[2]) && $_strurl[1] != "") {
        unset($_strurl[0]);
        unset($_strurl[1]);
        foreach ($_strurl as $_u) {
            $_params[] = $_u;
        }
    }
}

define("DS", DIRECTORY_SEPARATOR);
define("DIR", __DIR__);

require_once DIR . DS . 'vendor' . DS . 'autoload.php';
require_once DIR . DS . "controllers" . DS . "PagesController.php";

use App\Behavior\MainBehavior;

$MainBehavior = new MainBehavior();

$_model = $MainBehavior->getCamelCase($_controller) . "Model";
$_ctrl = $MainBehavior->getMethod($_controller);
$_controller = $MainBehavior->getCamelCase($_controller) . "Controller";

if (class_exists("PagesController") && method_exists("PagesController", $_ctrl)) {
    $_model = "PagesModel";
    $_controller = "PagesController";
    $_pathController = "pages";
    $_action = $_ctrl;
}

define("XACTION", $_action);
define("XCONTROLLER", strtolower(str_replace("Controller", "", $_controller)));
define("CONTROLLER", DIR . DS . "controllers" . DS . $_controller . ".php");
define("MODEL", DIR . DS . "models" . DS . $_model . ".php");
define("VIEW", DIR . DS . "views" . DS . str_replace("-", "_", $_pathController) . DS . $_action . ".phtml");

$test = true;
if (!file_exists(CONTROLLER)) {
    $test = false;
}
if (!file_exists(MODEL)) {
    $test = false;
}
if (!file_exists(VIEW)) {
    $test = false;
}

if (!$test) {
    header("Location: " . BASEURL . "/error/not_found_404");
    die();
}

require_once CONTROLLER;

$control = new $_controller(VIEW);

if (class_exists($_controller)) {
    if (method_exists($control, $_action)) {
        $control->$_action($_params);
        die();
    } else {
        header("Location: " . BASEURL . "/error/not_found_403");
        die();
    }
} else {
    header("Location: " . BASEURL . "/error/not_found_500");
    die();
}
