<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Login</title>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Admin Login</h1>

        <?php if (isset($message)): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="<?= ROOT ?>/admin/login" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark mb-2">Login</button>
                <a class="btn btn-secondary" href="<?= ROOT ?>/">Go Back to Homepage</a>
            </div>
        </form>
    </div>
</body>

</html>