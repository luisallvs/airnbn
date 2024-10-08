<?php

function index()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* Sanitize user input */
        $data = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'password' => $_POST['password'],
            'password_confirm' => $_POST['password_confirm'],
            'role' => htmlspecialchars($_POST['role']),
            'phone' => htmlspecialchars($_POST['phone'])
        ];

        /* Validate user input */
        if (
            !empty($data['name']) &&
            filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
            $data['password'] === $data['password_confirm'] &&
            strlen($data['password']) >= 8
        ) {

            /* Load User model */
            require_once 'models/Users.php';
            $model = new Users();

            /* Check if email is already registered */
            if (!$model->getByEmail($data['email'])) {
                /* Create user */
                $createdUserId = $model->create($data);

                /* Set session and redirect to home page */
                if ($createdUserId) {
                    $_SESSION['user_id'] = $createdUserId;
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_role'] = $data['role'];

                    header('Location: /');
                    exit;
                } else {
                    $message = "Erro ao criar a conta.";
                }
            } else {
                $message = "Email já registrado.";
            }
        } else {
            $message = "Preencha os dados corretamente e confirme a senha.";
        }
    }

    /* Load view */
    require 'views/register.php';
}
