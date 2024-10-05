<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>
    <h1>Crie sua conta</h1>
    <p>Se já tiver uma conta, <a href="<?= ROOT ?>/login/"> faça o login</a></p>

    <?php if (isset($message)) {
        echo '<p>' . $message . '</p>';
    } ?>

    <form action="/register" method="POST">
        <div>
            <label>Name:
                <input type="text" name="name" required><br>
            </label>
        </div>
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
            <label>Confirm Password:
                <input type="password" name="password_confirm" required><br>
            </label>
        </div>
        <div>
            <label>Role:
                <select name="role">
                    <option value="user">Guest</option>
                    <option value="host">Host</option>
                </select>
            </label>
        </div>
        <div>
            <label>Phone:
                <input type="text" name="phone" required><br>
            </label>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</body>

</html>