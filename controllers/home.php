<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function index()
{
    require_once 'views/home.php';
}
