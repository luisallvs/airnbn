<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Manage Reservations</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Manage Reservations</h1>

        <!-- Display messages if any -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_GET['message'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($reservations)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Property</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                                <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                                <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                                <td><?= htmlspecialchars($reservation['total_price']) ?> €</td>
                                <td>
                                    <!-- Display status correctly -->
                                    <?php if ($reservation['status'] === 'confirmed'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                    <?php elseif ($reservation['status'] === 'canceled'): ?>
                                        <span class="badge bg-danger">Canceled</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="<?= $reservation['is_paid'] ? 'text-success' : 'text-danger' ?>">
                                        <?= $reservation['is_paid'] ? 'Paid' : 'Not Paid' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($reservation['status'] === 'pending'): ?>
                                        <form action="<?= ROOT ?>/reservations/confirm/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                        </form>
                                        <form action="<?= ROOT ?>/reservations/cancel/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted"><?= ucfirst(htmlspecialchars($reservation['status'])) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No reservations available for your properties.</p>
        <?php endif; ?>
    </div>
</body>

</html>