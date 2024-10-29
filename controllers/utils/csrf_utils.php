<?php

function generateCsrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo "Generated CSRF Token: " . $_SESSION['csrf_token']; // Debug line
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token)
{
    if (isset($_SESSION['csrf_token']) && isset($token)) {
        $is_valid = hash_equals($_SESSION['csrf_token'], $token);
        echo "Validating CSRF Token: " . $_SESSION['csrf_token'] . " against Submitted Token: " . $token; // Debug line
        return $is_valid;
    }
    return false;
}

function clearCsrfToken()
{
    unset($_SESSION['csrf_token']);
}
