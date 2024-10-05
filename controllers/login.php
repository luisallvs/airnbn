<?php

class Login
{

    public function index()
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
                    header('Location: /');
                    exit;
                } else {
                    $message = "Email ou senha incorretos.";
                }
            } else {
                $message = "Preencha os dados corretamente.";
            }
        }

        /* Load view */
        require 'views/login.php';
    }
}
