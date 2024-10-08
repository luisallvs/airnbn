<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>
    <h1>Login</h1>
    <p>Don't have an account yet? <a href="<?= ROOT ?>/register/"> Register here</a></p>

    <?php if (isset($message)) {
        echo '<p>' . $message . '</p>';
    } ?>

    <form action="/login" method="POST">
        <div>
            <label>Email:
                <input type="email" name="email" required>
            </label>
        </div>
        <div>
            <label>Password:
                <input type="password" name="password" required>
            </label>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>

</html>