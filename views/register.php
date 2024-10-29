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
    <!-- Navbar -->
    <?php include 'templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">Create a New Account</h2>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-center">Already have an account? <a href="<?= ROOT ?>/login/" class="text-decoration-none fw-bold">Login here</a></p>

                        <!-- Display messages -->
                        <?php if (isset($message)): ?>
                            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <!-- Registration form -->
                        <form action="/register" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Password -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirm" class="form-label">Confirm Password:</label>
                                    <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Role:</label>
                                <select name="role" class="form-select">
                                    <option value="guest">Guest</option>
                                    <option value="host">Host</option>
                                </select>
                            </div>

                            <!-- Profile Picture -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture:</label>
                                <input type="file" name="profile_picture" class="form-control" accept="image/*">
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-dark btn-lg">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p class="text-muted">Airnbn © 2024</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>