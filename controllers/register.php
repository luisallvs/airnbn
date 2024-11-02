<?php

require_once 'models/Users.php';

require_once 'controllers/utils/file_utils.php';
require_once 'controllers/utils/csrf_utils.php';

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function index()
{
    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';

        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

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
            $profilePicturePath = uploadProfilePicture($_FILES['profile_picture'], []);
            $data['profile_picture'] = $profilePicturePath;
        } else {
            $data['profile_picture'] = null;
        }

        /* Validate user input */
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

                /* Set session and redirect to home page */
                if ($createdUserId) {
                    $_SESSION['user_id'] = (int) $createdUserId;
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_role'] = $data['role'];

                    $user = $model->getById($createdUserId);
                    $_SESSION['user_profile_picture'] = $user['profile_picture'];

                    /* send confirmation email */
                    $mail = new PHPMailer(true);

                    try {
                        /* Server settings */
                        $mail->isSMTP();
                        $mail->Host       = ENV['SMTP_HOST'];
                        $mail->SMTPAuth   = true;
                        $mail->Username   = ENV['SMTP_USER'];
                        $mail->Password   = ENV['SMTP_PASSWORD'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        /* Recipients */
                        $mail->setFrom(ENV['SMTP_USER'], 'Airnbn Team');
                        $mail->addAddress($data['email'], $data['name']);

                        /* Email content */
                        $mail->isHTML(true);
                        $mail->Subject = 'Registration Confirmation';
                        $mail->Body    = 'Hello ' . htmlspecialchars($data['name']) . '!!<br><br>Thank you for registering your account at Airnbn. Your account has been successfully created!<br><br>Best Regards,<br>The Airnbn Team';

                        $mail->send();
                    } catch (Exception $error) {
                        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                    }

                    http_response_code(200);
                    header('Location: /');
                    return;
                } else {
                    http_response_code(500);
                    $errorCode = 500;
                    $errorMessage = 'An error occurred while creating the user. Please try again later.';
                    require 'views/errors/error.php';
                    return;
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
