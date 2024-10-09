<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>

<body>
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <h1>Your Profile</h1>

    <?php if (!empty($user['profile_picture'])): ?>
        <img src="<?= ROOT . htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px; border-radius: 50%;">
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>


    <?php if (isset($user)): ?>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Joined on:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

        <!-- Only display the edit link if the user is viewing their own profile -->
        <?php if ($_SESSION['user_id'] == $user['user_id']): ?>
            <a href="<?= ROOT ?>/profile/update">Edit Profile</a>
        <?php endif; ?>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>

</html>