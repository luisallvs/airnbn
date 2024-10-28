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
$param1 = !empty($url_parts[2]) ? $url_parts[2] : null;
$param2 = !empty($url_parts[3]) ? $url_parts[3] : null;

if ($controller === 'admin') {
    $controller = !empty($url_parts[1]) ? $url_parts[1] : 'dashboard';
    $method = !empty($url_parts[2]) ? $url_parts[2] : 'index';
    $param1 = !empty($url_parts[3]) ? $url_parts[3] : null;
    $param2 = !empty($url_parts[4]) ? $url_parts[4] : null;

    $controllerFile = "controllers/admin/$controller.php";
} else {
    $controllerFile = "controllers/$controller.php";
}

/* Check if the controller file exists */
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    /* Check if the method exists as a function */
    if (function_exists($method)) {
        $reflection = new ReflectionFunction($method);
        $paramCount = $reflection->getNumberOfParameters();

        /* handle the parameters */
        if ($paramCount === 2 && (is_null($param1) || is_null($param2))) {
            http_response_code(404);
            loadErrorPage(404, "It seems this page is missing some information. Please check the URL or return to the home page.");
        } elseif ($paramCount === 2) {
            call_user_func($method, $param1, $param2);
        } elseif ($paramCount === 1 && !is_null($param1)) {
            call_user_func($method, $param1);
        } else {
            call_user_func($method);
        }
    } else {
        http_response_code(404);
        loadErrorPage(404, "Sorry, we couldn't find the page you're looking for. Please return to the home page.");
    }
} else {
    http_response_code(404);
    loadErrorPage(404, "Oops! The page you're looking for doesn't exist. Please go back to the home page.");
}

/* Function to load error page */
function loadErrorPage($errorCode = 404, $errorMessage = "Page not found")
{
    http_response_code($errorCode);
    $errorCode = htmlspecialchars($errorCode);
    $errorMessage = htmlspecialchars($errorMessage);
    include "views/errors/error.php";
    exit();
}
