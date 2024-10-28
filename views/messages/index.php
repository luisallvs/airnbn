<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inbox</title>
    <style>
        .inbox-header {
            background-color: #62BFED;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #f1f1f1;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .conversation-info strong {
            font-size: 1.1rem;
        }

        .conversation-info small {
            color: #6c757d;
        }

        .btn-view {
            background-color: #62BFED;
            border-color: #62BFED;
            color: white;
        }

        .btn-view:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: white;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="inbox-header text-center">
                <h1 class="mb-0">Inbox</h1>
            </div>
            <div class="card-body">
                <?php if (!empty($conversations)): ?>
                    <ul class="list-group">
                        <?php foreach ($conversations as $conversation): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="conversation-info">
                                    <strong><?= htmlspecialchars($conversation['other_user_name']) ?></strong><br>
                                    <small>Property Name: <?= htmlspecialchars($conversation['property_name']) ?></small>
                                </div>
                                <a href="<?= ROOT ?>/messages/conversation/<?= htmlspecialchars($conversation['user_id']) ?>/<?= htmlspecialchars($conversation['property_id']) ?>" class="btn btn-view btn-sm">View Conversation</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-secondary text-center" role="alert">
                        No conversations found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>