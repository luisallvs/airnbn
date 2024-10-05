<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>
    <h1>Entre na sua conta</h1>
    <p>Se ainda não tiver conta, <a href="<?= ROOT ?>/register/"> crie uma facilmente</a></p>

    <?php if (isset($message)) {
        echo '<p>' . $message . '</p>';
    } ?>

    <form action="/login" method="POST">
        <div>
            <label>Email:
                <input type="email" name="email" required><br>
            </label>
        </div>
        <div>
            <label>Password:
                <input type="password" name="password" required><br>
            </label>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>

</html>