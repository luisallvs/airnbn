<?php

function index()
{
    session_destroy();  /* Destroy session */
    header('Location: /login');  /* Redirect to login page */
    exit;
}
