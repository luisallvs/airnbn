<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airnbn</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <h1>Welcome to Airnbn</h1>

    <h2>Hello,
        <?php if (isset($_SESSION['user_name'])): ?>
            <?= htmlspecialchars($_SESSION['user_name']) ?>!
        <?php else: ?>
            Guest!
        <?php endif; ?>
    </h2>

    <?php if (!empty($_SESSION['user_profile_picture']) && file_exists(__DIR__ . '/../' . $_SESSION['user_profile_picture'])): ?>
        <img src="<?= ROOT . htmlspecialchars($_SESSION['user_profile_picture']) ?>" alt="Profile Picture" style="max-width: 200px; max-height: 200px; border-radius: 50%;">
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>
</body>

</html>