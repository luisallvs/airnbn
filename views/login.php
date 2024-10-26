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
    <!-- Navbar -->
    <?php include 'templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">Login</h2>
                    </div>
                    <div class="card-body p-4">

                        <!-- Login admin and register -->
                        <p class="text-center">Don't have an account? <a href="<?= ROOT ?>/register/" class="text-decoration-none fw-bold">Register here</a></p>
                        <p class="text-center">Admin? <a href="<?= ROOT ?>/admin/login/" class="text-decoration-none fw-bold">Login here</a></p>

                        <!-- Alert message -->
                        <?php if (isset($message)): ?>
                            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <!-- Login form -->
                        <form action="/login" method="POST" class="mx-auto">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                            </div>

                            <div class="mb-5">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p class="text-muted">Secure Login | © 2024 Airnbn</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>