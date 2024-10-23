<?php

function index()
{
    session_destroy();
    header('Location: ' . ROOT . '/admin/login');
    exit();
}
