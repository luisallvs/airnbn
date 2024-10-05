<?php
session_start();

define("ENV", parse_ini_file('.env'));
define("ROOT", "");

$request_uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$controller = !empty($request_uri[0]) ? $request_uri[0] : "home";
$method = "index";

// Build the controller file path
$controllerFile = "controllers/" . $controller . ".php";

// Check if controller file exists
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Instantiate the controller
    if (class_exists($controller)) {
        $controllerObject = new $controller();
        $controllerObject->$method();
    } else {
        die("Class not found: " . $controller);
    }
} else {
    die("Controller file not found: " . $controllerFile);
}
