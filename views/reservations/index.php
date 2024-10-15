<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>My Reservations</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">My Reservations</h1>

        <?php if (!empty($reservations)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Property Name</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                                <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                                <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                                <td>€<?= htmlspecialchars($reservation['total_price']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($reservation['status'])) ?></td>
                                <td><?= htmlspecialchars($reservation["payment_status"]) ?></td>
                                <td>
                                    <a href="<?= ROOT ?>/reservations/showDetails/<?= htmlspecialchars($reservation['reservation_id']) ?>" class="btn btn-primary btn-sm">View Details</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">You have no reservations yet.</p>
        <?php endif; ?>
    </div>
</body>

</html>