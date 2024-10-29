<?php

require_once 'models/users.php';
require_once 'models/messages.php';

require_once 'controllers/utils/csrf_utils.php';

/* Show a list of conversations for the user */
function index()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        require 'views/errors/401.php';
        return;
    }

    $model = new Messages();
    $user_id = $_SESSION['user_id'];

    /* Get unread messages count */
    $unreadMessagesCount = $model->getUnreadMessagesCount($user_id);

    /* Get conversations */
    $conversations = $model->getUserConversations($user_id);

    require 'views/messages/index.php';
}

/* Show conversation and send a message */
function conversation($receiver_id, $property_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        require 'views/errors/401.php';
        return;
    }

    /* models */
    $messagesModel = new Messages();
    $usersModel = new Users();
    $sender_id = $_SESSION['user_id'];

    /* get the receiver name */
    $other_user = $usersModel->getById($receiver_id);
    if (!$other_user) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = "User not found.";
        require 'views/errors/404.php';
        return;
    }
    $other_user_name = $other_user['name'];

    /* mark messages as read */
    if ($receiver_id !== $sender_id) {
        $messagesModel->markMessagesAsRead($sender_id, $property_id);
    }

    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    /* handle message send */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';

        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        $content = htmlspecialchars(trim($_POST['content']));
        $messagesModel->sendMessage($sender_id, $receiver_id, $property_id, $content);

        header("Location: " . ROOT . "/messages/conversation/$receiver_id/$property_id");
        exit();
    }

    /* get conversation */
    $messages = $messagesModel->getConversation($sender_id, $receiver_id, $property_id);

    require 'views/messages/conversation.php';
}

function markAsRead($receiver_id, $property_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = "You have to be logged in to view messages.";
        require 'views/errors/error.php';
        return;
    }

    $messagesModel = new Messages();
    $receiver_id = $_SESSION['user_id']; // Current logged-in user is the receiver

    $messagesModel->markMessagesAsRead($receiver_id, $property_id);
}
