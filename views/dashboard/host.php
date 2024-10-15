<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Host Dashboard</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Host Dashboard</h1>

        <!-- row for overwview cards -->
        <div class="row g-4">
            <!-- total reservations -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Reservations</h5>
                        <p class="display-6">
                            <?= isset($reservations) && is_array($reservations) ? count($reservations) : '<span class="text-muted">0</span>' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- upcoming reservations -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Upcoming Reservations</h5>
                        <p class="display-6">
                            <?= count($reservations ?? []) ?>
                        </p>
                        <a href="<?= ROOT ?>/reservations/manage" class="btn btn-primary">Manage Reservations</a>
                    </div>
                </div>
            </div>

            <!-- total earnings -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Earnings</h5>
                        <p class="display-6">
                            €<?= number_format($totalEarnings ?? 0, 2) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- recent activity -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="mb-4">Recent Activity</h3>
                <?php if (!empty($recentActivities)): ?>
                    <ul class="list-group">
                        <?php foreach ($recentActivities as $activity): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <strong><?= htmlspecialchars($activity['property_name']) ?></strong>
                                    - <?= ucfirst($activity['status']) ?>
                                </span>
                                <span class="text-muted">
                                    <?= htmlspecialchars($activity['check_in']) ?> to <?= htmlspecialchars($activity['check_out']) ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No recent activity found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>