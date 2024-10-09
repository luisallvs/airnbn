<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Edit Your Profile</h1>

    <?php if (isset($message) && !empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="<?= ROOT ?>/profile/update" method="POST" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required><br>
            </li>
            <li>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required><br>
            </li>
            <li>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required><br>
            </li>
            <li>
                <label for="current_password">Current password:</label>
                <input type="password" name="current_password"><br>
            </li>
            <li>
                <label for="password">New password:</label>
                <input type="password" name="new_password"><br>
            </li>
            <li>
                <label for="password_confirm">Confirm new password:</label>
                <input type="password" name="confirm_password"><br>
            </li>
            <li>
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" accept="image/*">
            </li>
            <div>
                <button type="submit">Save Changes</button>
            </div>
        </ul>
    </form>
</body>

</html>