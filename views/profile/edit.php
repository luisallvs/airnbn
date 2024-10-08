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

    <form action="<?= ROOT ?>/profile/edit" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>

</html>