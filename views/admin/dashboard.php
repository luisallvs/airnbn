<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Admin Dashboard</h1>

        <!-- summary -->
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="display-4"><?= $totalUsers ?? 0 ?></p>
                        <a href="<?= ROOT ?>/admin/users" class="btn btn-outline-primary">Manage Users</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Properties</h5>
                        <p class="display-4"><?= $totalProperties ?? 0 ?></p>
                        <a href="<?= ROOT ?>/admin/properties" class="btn btn-outline-success">Manage Properties</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Reservations</h5>
                        <p class="display-4"><?= $totalReservations ?? 0 ?></p>
                        <a href="<?= ROOT ?>/admin/reservations" class="btn btn-outline-warning">Manage Reservations</a>
                    </div>
                </div>
            </div>
        </div>

        <h3>Last 5 Users Created</h3>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lastFiveUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?= ROOT ?>/admin/users" class="btn btn-primary mb-4">Show All Users</a>

        <h3>Last 5 Properties Created</h3>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Property ID</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Price per Night</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lastFiveProperties as $property): ?>
                    <tr>
                        <td><?= htmlspecialchars($property['property_id']) ?></td>
                        <td><?= htmlspecialchars($property['name']) ?></td>
                        <td><?= htmlspecialchars($property['owner_name']) ?></td>
                        <td><?= htmlspecialchars($property['price_per_night']) ?></td>
                        <td><?= htmlspecialchars($property['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?= ROOT ?>/admin/properties" class="btn btn-success mb-4">Show All Properties</a>

        <h3>Recent Reservations</h3>
        <table class="table table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Reservation ID</th>
                    <th>User</th>
                    <th>Property</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentReservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                        <td><?= htmlspecialchars($reservation['user_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?= ROOT ?>/admin/reservations" class="btn btn-warning mb-4">Show All Reservations</a>
    </div>

</body>

</html>