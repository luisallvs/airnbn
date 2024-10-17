<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Reservation Details</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Reservation Details</h1>

        <?php if ($reservation): ?>
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($reservation['property_name']) ?></h2>
                    <p><strong>Address:</strong> <?= htmlspecialchars($reservation['property_address']) ?>, <?= htmlspecialchars($reservation['property_city']) ?></p>
                    <p><strong>Check-in:</strong> <?= htmlspecialchars($reservation['check_in']) ?></p>
                    <p><strong>Check-out:</strong> <?= htmlspecialchars($reservation['check_out']) ?></p>
                    <p><strong>Total Price:</strong> €<?= htmlspecialchars($reservation['total_price']) ?></p>

                    <p><strong>Payment Status:</strong>
                        <span class="badge <?= $reservation['is_paid'] ? 'bg-success' : 'bg-danger' ?>">
                            <?= $reservation['is_paid'] ? 'Paid' : 'Not Paid' ?>
                        </span>
                    </p>

                    <p><strong>Status:</strong>
                        <span class="badge <?= $reservation['status'] === 'confirmed' ? 'bg-success' : ($reservation['status'] === 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                            <?= ucfirst($reservation['status']) ?>
                        </span>
                    </p>

                    <!-- show pay now button if not paid -->
                    <?php if ($reservation['is_paid'] == 0): ?>
                        <form action="<?= ROOT ?>/payments/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST" class="mt-3">
                            <button type="submit" class="btn btn-primary btn-md">Pay Now</button>
                        </form>
                    <?php elseif ($reservation['is_paid'] == 1): ?>
                        <p class="text-success mt-3">Thank you! Your payment has been completed.</p>
                    <?php endif; ?>

                    <!-- Leave review button only displays if reservation is paid and completed -->
                    <?php if ($reservation['is_paid'] && strtotime($reservation['check_out']) < time()): ?>
                        <a href="<?= ROOT ?>/reviews/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" class="btn btn-warning mt-3">Leave a Review</a>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= ROOT ?>/reservations" class="btn btn-secondary">Back to Reservations</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">Reservation not found.</p>
        <?php endif; ?>
    </div>
</body>

</html>