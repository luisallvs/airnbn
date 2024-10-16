<?php

function index()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* Sanitize user input */
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
            /* Load User model */
            require_once 'models/Users.php';
            $model = new Users();

            /* Check if email is already registered */
            $user = $model->getByEmail($email);

            /* Check if password is correct */
            if ($user && password_verify($password, $user['password'])) {
                /* Create session */
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_profile_picture'] = $user['profile_picture'];

                http_response_code(200);
                header('Location: /');
            } else {
                http_response_code(401);
                $message = "Email or password is incorrect.";
            }
        } else {
            http_response_code(400);
            $message = "Please enter your email and password.";
        }
    }

    /* Load view */
    require 'views/login.php';
}
