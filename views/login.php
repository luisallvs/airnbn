<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <p class="text-center">Don't have an account yet? <a href="<?= ROOT ?>/register/" class="text-decoration-none">Register here</a></p>

        <?php if (isset($message)): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="/login" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Login</button>
            </div>
        </form>
    </div>
</body>

</html>