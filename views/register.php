<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Create a New Account</h1>
        <p class="text-center">Already have an account? <a href="<?= ROOT ?>/login/" class="text-decoration-none">Login here</a></p>

        <?php if (isset($message)): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="/register" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirm Password:</label>
                <input type="password" name="password_confirm" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" class="form-select">
                    <option value="guest">Guest</option>
                    <option value="host">Host</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture:</label>
                <input type="file" name="profile_picture" class="form-control" accept="image/*">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Register</button>
            </div>
        </form>
    </div>
</body>

</html>