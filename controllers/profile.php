<?php

require_once 'models/Users.php';

/* Function to display the user profile */
function index()
{
    /* Make sure the user is logged in */
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if ($user) {
        http_response_code(200);
    } else {
        http_response_code(404);
    }

    require 'views/profile.php';
}

function update()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Users();
    $user = $model->getById($user_id);

    if (!$user) {
        http_response_code(404);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* Sanitize input */
        $name = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        /* handle profile picture */
        $profilePicture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES['profile_picture']['tmp_name']);
            $profilePicture = base64_encode($imageData);
        }

        /* Validate input */
        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone)) {
            http_response_code(400);
            $message = "Please fill in all fields correctly.";
        } else {

            $updateData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ];

            if ($profilePicture) {
                $updateData['profile_picture'] = $profilePicture;
            }

            /* Update password */
            if (!empty($newPassword) && !empty($currentPassword) && $newPassword === $confirmPassword) {
                if (password_verify($currentPassword, $user['password'])) {
                    $updateData['password'] = $newPassword;
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

                    /* Update session variables */
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_phone'] = $phone;

                    if (isset($updateData['profile_picture'])) {
                        $_SESSION['user_profile_picture'] = $updateData['profile_picture'];
                    }

                    http_response_code(200);
                    $message = "Profile updated successfully.";
                    // Refresh the user data after updating
                    $user = $model->getById($user_id);
                } else {
                    http_response_code(500);
                    $message = "An error occurred while updating your profile.";
                }
            }
        }
    }

    require 'views/profile/edit.php';
}
