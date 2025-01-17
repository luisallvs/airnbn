<?php

require_once 'models/Users.php';

require_once 'controllers/utils/file_utils.php';
require_once 'controllers/utils/csrf_utils.php';

/* Function to display the user profile */
function index()
{
    /* Make sure the user is logged in */
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to view your profile.';
        require 'views/errors/error.php';
        return;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if ($user) {
        http_response_code(200);
        /* generate csrf token */
        $csrf_token = generateCsrfToken();
    } else {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'User not found.';
        require 'views/errors/error.php';
        return;
    }

    require 'views/profile.php';
}

function update()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to update your profile.';
        require 'views/errors/error.php';
        return;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if (!$user) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'User not found.';
        require 'views/errors/error.php';
        return;
    }

    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';

        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        /* Sanitize input */
        $name = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        /* Handle profile picture */
        $profilePicturePath = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $profilePicturePath = uploadProfilePicture($_FILES['profile_picture'], $user);
            if (!$profilePicturePath) {
                $message = "Failed to upload profile picture.";
            }
        }

        /* Validate input */
        if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phone)) {
            $updateData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ];

            if ($profilePicturePath) {
                $updateData['profile_picture'] = $profilePicturePath;
            }

            /* Update password if provided and valid */
            if (!empty($newPassword) && !empty($currentPassword) && $newPassword === $confirmPassword) {
                if (password_verify($currentPassword, $user['password'])) {
                    $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);  // Hash the new password
                } else {
                    http_response_code(403);
                    $message = "Your current password is incorrect.";
                }
            } elseif (!empty($newPassword) || !empty($confirmPassword || !empty($currentPassword))) {
                http_response_code(400);
                $message = "Please fill in all fields correctly for the password update.";
            }

            if (empty($message)) {

                /* Update user data in the database */
                if ($model->update($user_id, $updateData)) {
                    $updatedUser = $model->getById($user_id);

                    /* Update session variables */
                    $_SESSION['user_name'] = $updatedUser['name'];
                    $_SESSION['user_email'] = $updatedUser['email'];
                    $_SESSION['user_phone'] = $updatedUser['phone'];
                    $_SESSION['user_profile_picture'] = $updatedUser['profile_picture'];

                    http_response_code(200);
                    header('Location: ' . ROOT . '/profile');

                    $user = $model->getById($user_id);
                } else {
                    http_response_code(500);
                    $errorCode = 500;
                    $errorMessage = 'An error occurred while updating the profile.';
                    require 'views/errors/error.php';
                    return;
                }
            }
        } else {
            http_response_code(400);
            $message = "Please fill in all fields correctly.";
        }
    }
    require 'views/profile/edit.php';
}

function delete()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to delete your account.';
        require 'views/errors/error.php';
        return;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if (!$user) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'User not found.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        $deletePassword = $_POST['delete_password'] ?? '';

        if (!password_verify($deletePassword, $user['password'])) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Incorrect password. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        /* delete profile picture */
        if (!empty($user['profile_picture'])) {
            $oldProfilePicturePath = __DIR__ . '/../' . ltrim($user['profile_picture'], '/');
            if (file_exists($oldProfilePicturePath)) {
                unlink($oldProfilePicturePath);
            }
        }

        if ($model->delete($user_id)) {
            session_unset();
            session_destroy();
            header('Location: ' . ROOT . '/login');
            exit();
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'An error occurred while deleting your account. Please try again.';
            require 'views/errors/error.php';
            return;
        }
    }

    require 'views/errors/error.php';
}
