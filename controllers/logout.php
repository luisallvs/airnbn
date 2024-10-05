<?php

class Logout
{

    public function index()
    {
        session_start();
        session_destroy();  /* Destroy session */
        header('Location: /login');  /* Redirect to login page */
        exit;
    }
}
