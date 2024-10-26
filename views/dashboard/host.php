<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Host Dashboard</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-5 display-4 text-primary">Host Dashboard</h1>

        <!-- Overview Cards Row -->
        <div class="row g-4">
            <!-- Total Reservations -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title text-secondary">Total Reservations</h5>
                        <p class="display-6 fw-bold text-primary">
                            <?= isset($reservations) && is_array($reservations) ? count($reservations) : '<span class="text-muted">0</span>' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Reservations -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title text-secondary">Upcoming Reservations</h5>
                        <p class="display-6 fw-bold text-success">
                            <?= count($reservations ?? []) ?>
                        </p>
                        <a href="<?= ROOT ?>/reservations/manage" class="btn btn-outline-primary mt-3">Manage Reservations</a>
                    </div>
                </div>
            </div>

            <!-- Total Earnings -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title text-secondary">Total Earnings</h5>
                        <p class="display-6 fw-bold text-warning">
                            €<?= number_format($totalEarnings ?? 0, 2) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="mb-4 text-secondary">Recent Activity</h3>
                <?php if (!empty($recentActivities)): ?>
                    <ul class="list-group list-group-flush shadow-sm">
                        <?php foreach ($recentActivities as $activity): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1"><?= htmlspecialchars($activity['property_name']) ?></h5>
                                    <small class="text-muted"><?= ucfirst($activity['status']) ?> Reservation</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    <?= htmlspecialchars($activity['check_in']) ?> - <?= htmlspecialchars($activity['check_out']) ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center">No recent activity found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>