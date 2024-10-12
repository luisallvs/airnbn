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
            'phone' => htmlspecialchars($_POST['phone']),
            "profile_picture" => null
        ];

        /* Handle profile picture */
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES['profile_picture']['tmp_name']);
            $data['profile_picture'] = base64_encode($imageData);
        }

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

                    $user = $model->getById($createdUserId);
                    $_SESSION['user_profile_picture'] = $user['profile_picture'];

                    http_response_code(200);
                    header('Location: /');
                    exit;
                } else {
                    http_response_code(500);
                    $message = "Error creating user.";
                }
            } else {
                http_response_code(409);
                $message = "Email already registered.";
            }
        } else {
            http_response_code(400);
            $message = "Please fill in all fields and make sure the password is at least 8 characters long.";
        }
    }

    /* Load view */
    require 'views/register.php';
}
