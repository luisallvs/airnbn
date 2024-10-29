<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Create New User</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="text-center mb-0">Create New User</h2>
                    </div>
                    <div class="card-body p-4">

                        <?php if (isset($message)): ?>
                            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <!-- form -->
                        <form action="<?= ROOT ?>/admin/users/create" method="POST" enctype="multipart/form-data">

                            <!-- user name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                            </div>

                            <!-- user email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>

                            <!-- user phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                            </div>

                            <!-- user password -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirm" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirm" class="form-control" placeholder="Re-enter password" required>
                                </div>
                            </div>

                            <!-- user role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="guest">Guest</option>
                                    <option value="host">Host</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <!-- profile picture -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture (Optional)</label>
                                <input type="file" name="profile_picture" class="form-control" accept=".jpg, .jpeg, .png, .gif, .webp">
                            </div>

                            <!-- submit and back buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-success">Create User</button>
                                <a href="<?= ROOT ?>/admin/users" class="btn btn-secondary">Back to Users</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>