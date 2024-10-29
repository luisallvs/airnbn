<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>User Profile</title>
</head>

<body>
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">User Profile</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <?php if (!empty($user['profile_picture'])): ?>
                                            <img src="<?= ROOT . htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/150" alt="Default Picture" class="img-fluid rounded-circle mb-3">
                                            <p class="text-muted">No profile picture available.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- User Information -->
                            <div class="col-md-8">
                                <h3 class="card-title text-center mb-3"><?= htmlspecialchars($user['name']) ?></h3>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                                    <li class="list-group-item"><strong>Role:</strong> <span class="badge bg-info"><?= htmlspecialchars($user['role']) ?></span></li>
                                    <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></li>
                                    <li class="list-group-item"><strong>Joined on:</strong> <?= htmlspecialchars($user['created_at']) ?></li>
                                </ul>

                                <!-- Edit Profile Button -->
                                <?php if ($_SESSION['user_id'] == $user['user_id']): ?>
                                    <div class="d-grid mt-4">
                                        <a href="<?= ROOT ?>/profile/update" class="btn btn-primary"><i class="bi bi-pencil-square"></i></i> Edit Profile</a>
                                        <!-- Delete Account Button -->
                                        <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteAccountModal"><i class="bi bi-trash"></i> Delete Account</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= ROOT ?>/profile/delete" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->
                    <div class="modal-body">
                        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                        <div class="mb-3">
                            <label for="deletePassword" class="form-label">Enter Password:</label>
                            <input type="password" class="form-control" id="deletePassword" name="delete_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>