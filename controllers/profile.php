<?php

require_once 'models/Users.php';

/* Function to display the user profile */
function index()
{
    /* Make sure the user is logged in */
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    require 'views/profile.php';
}

function edit()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* Sanitize input */
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars($_POST['phone']);

        /* Validate input */
        if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phone)) {
            $model->update($user_id, [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ]);

            /* Update session */
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;


            $message = "Profile updated successfully.";
            // Refresh the user data after updating
            $user = $model->getById($user_id);
        } else {
            $message = "Please fill in all fields correctly.";
        }
    }

    require 'views/profile/edit.php';
}
