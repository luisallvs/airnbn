<?php

/* Start the session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("ENV", parse_ini_file('.env'));
define("ROOT", "");

/* Get the request URI and remove leading/trailing slashes */
$request_uri = trim($_SERVER["REQUEST_URI"], "/");
$url_parts = explode("/", $request_uri);

/* Set default controller and method */
$controller = !empty($url_parts[0]) ? $url_parts[0] : "home";
$method = !empty($url_parts[1]) ? $url_parts[1] : "index";
$param = !empty($url_parts[2]) ? $url_parts[2] : null;

/* Define the controller file pat */
$controllerFile = "controllers/" . $controller . ".php";

/* Check if the controller file exists */
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    /* Check if the method exists as a function */
    if (function_exists($method)) {
        echo "Calling method $method in $controllerFile"; //!!!!debug!!!!!
        if ($param) {
            call_user_func($method, $param);
        } else {
            call_user_func($method);
        }
    } else {
        http_response_code(404);
        loadErrorPage(404, "Method not found: " . htmlspecialchars($method));
    }
} else {
    http_response_code(404);
    loadErrorPage(404, "Controller file not found: " . htmlspecialchars($controllerFile));
}

/* fucntion to load error page */
function loadErrorPage($code, $message)
{
    include "views/errors/error.php";
    exit();
}
