<?php

require_once 'models/Users.php';
require_once 'controllers/file_utils.php';

function index()
{
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $userModel = new Users();
    $allUsers = $userModel->getAll();
    require 'views/admin/users.php';
}

function create()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* Sanitize user input */
        $data = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'password' => $_POST['password'],
            'password_confirm' => $_POST['password_confirm'],
            'role' => htmlspecialchars($_POST['role']),
            'phone' => htmlspecialchars($_POST['phone']),
            'profile_picture' => null
        ];

        /* Handle profile picture */
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $profilePicturePath = uploadProfilePicture($_FILES['profile_picture']);
            $data['profile_picture'] = $profilePicturePath;
        }

        /* Validate input */
        if (
            !empty($data['name']) &&
            filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
            $data['password'] === $data['password_confirm'] &&
            strlen($data['password']) >= 8
        ) {
            /* Hash password */
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            /* Load User model */
            $model = new Users();

            /* Check if email is already registered */
            if (!$model->getByEmail($data['email'])) {
                /* Create user */
                $createdUserId = $model->create($data);

                if ($createdUserId) {
                    http_response_code(200);
                    header('Location: /admin/users');
                    exit();
                } else {
                    $message = "Failed to create user.";
                }
            } else {
                $message = "Email already registered.";
            }
        } else {
            $message = "Please fill in all fields and make sure the password is at least 8 characters long.";
        }
    }

    require 'views/admin/createUser.php';
}


function edit($user_id)
{
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $userModel = new Users();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedData = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'phone' => htmlspecialchars($_POST['phone']),
            'role' => $_POST['role']
        ];

        /* Check if profile picture was provided */
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $profilePicturePath = uploadProfilePicture($_FILES['profile_picture']);
            if ($profilePicturePath) {
                $updatedData['profile_picture'] = $profilePicturePath;
            } else {
                $message = "Failed to upload profile picture.";
            }
        }

        if (!empty($_POST['password'])) {
            $updatedData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if ($userModel->update($user_id, $updatedData)) {
            header("Location: /admin/users");
            exit();
        } else {
            $message = "Failed to update user.";
        }
    }

    $user = $userModel->getById($user_id);
    require 'views/admin/editUser.php';
}

function delete($user_id)
{

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $userModel = new Users();

    // Attempt to delete the user
    if ($userModel->delete($user_id)) {
        http_response_code(200);
        header("Location: /admin/users");
        exit();
    } else {
        http_response_code(500);
        $errorCode = 500;
        $errorMessage = 'Failed to delete user.';
        require 'views/errors/error.php';
    }
}
