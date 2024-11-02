<?php

function generateCsrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token)
{
    if (isset($_SESSION['csrf_token']) && isset($token)) {
        $is_valid = hash_equals($_SESSION['csrf_token'], $token);
        return $is_valid;
    }
    return false;
}

function clearCsrfToken()
{
    unset($_SESSION['csrf_token']);
}
