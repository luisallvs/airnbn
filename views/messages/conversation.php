<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Conversation</title>
    <style>
        .chat-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .message {
            max-width: 60%;
            padding: 10px;
            border-radius: 15px;
            margin-bottom: 10px;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message.you {
            background-color: #e9ecef;
            margin-left: auto;
            text-align: right;
            border-bottom-right-radius: 0;
        }

        .message.other {
            background-color: #007bff;
            color: white;
            border-bottom-left-radius: 0;
        }

        .chat-header {
            background-color: #62BFED;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .chat-form {
            border-top: 1px solid #dee2e6;
            padding: 15px;
        }
    </style>
    <script src="<?= ROOT ?>/js/messages/markAsRead.js"></script>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-sm mb-4">
            <div class="chat-header">
                <h2>Conversation with <?= htmlspecialchars($other_user_name) ?></h2>
            </div>
            <div class="card-body chat-container">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="message <?= $message['sender_id'] === $_SESSION['user_id'] ? 'you' : 'other' ?>">
                            <strong><?= $message['sender_id'] === $_SESSION['user_id'] ? 'You' : htmlspecialchars($other_user_name) ?>:</strong>
                            <p class="mb-1"><?= htmlspecialchars($message['content']) ?></p>
                            <small class="text-muted">Sent on: <?= htmlspecialchars($message['created_at']) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">No messages yet. Start the conversation!</p>
                <?php endif; ?>
            </div>
            <div class="chat-form">
                <form action="<?= ROOT ?>/messages/conversation/<?= htmlspecialchars($receiver_id) ?>/<?= htmlspecialchars($property_id) ?>" method="POST">
                    <div class="input-group">
                        <textarea name="content" class="form-control" placeholder="Type your message here..." rows="1" required></textarea>
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>