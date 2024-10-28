<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>All Users</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">

        <h1 class="text-center mb-4">All Users</h1>
        <div class="d-flex flex-row justify-content-between">

            <!-- create user button -->
            <div class="d-flex justify-content-start mb-2">
                <a href="<?= ROOT ?>/admin/users/create" class="btn btn-primary">Create User</a>
            </div>

            <!-- back to dashboard button -->
            <div class="d-flex justify-content-start mb-2">
                <a href="/" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <!-- users table -->
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Created At</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td class="text-center">
                            <a href="<?= ROOT ?>/admin/users/edit/<?= $user['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= ROOT ?>/admin/users/delete/<?= $user['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>