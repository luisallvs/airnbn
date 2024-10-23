<?php

require_once 'models/Users.php';

function index()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (!empty($email) && !empty($password)) {
            $userModel = new Users();
            $user = $userModel->getByEmail($email);

            /* Check if user exists and password is correct */
            if ($user && $user['role'] === 'admin' && password_verify($password, $user['password'])) {
                /* Regenerate session ID for security */
                session_regenerate_id();

                /* Set session variables */
                $_SESSION['admin'] = $user['user_id'];
                $_SESSION['admin_name'] = $user['name'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                header('Location: ' . ROOT . '/admin/dashboard');
                exit();
            } else {
                $message = "Invalid email or password, or you do not have admin privileges.";
            }
        } else {
            $message = "Please enter your email and password.";
        }
    }

    require 'views/admin/login.php';
}
