<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>
    <h1>Make a new account</h1>
    <p>Already have an account? <a href="<?= ROOT ?>/login/"> Login here</a></p>

    <?php if (isset($message)) {
        echo '<p>' . $message . '</p>';
    } ?>

    <form action="/register" method="POST" enctype="multipart/form-data">
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
                    <option value="guest">Guest</option>
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