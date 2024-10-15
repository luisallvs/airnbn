<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>User Profile</title>
</head>

<body>
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <h2>Profile</h2>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <?php if (!empty($user['profile_picture'])): ?>
                            <img src="<?= ROOT . htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3 w-100" style="max-width: 200px;">
                        <?php else: ?>
                            <p>No profile picture available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($user)): ?>
                            <h3 class="card-title"><?= htmlspecialchars($user['name']) ?></h3>
                            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                            <p class="card-text"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
                            <p class="card-text"><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                            <p class="card-text"><strong>Joined on:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

                            <!-- Only display the edit link if the user is viewing their own profile -->
                            <?php if ($_SESSION['user_id'] == $user['user_id']): ?>
                                <a href="<?= ROOT ?>/profile/update" class="btn btn-primary">Edit Profile</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-danger">User not found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>