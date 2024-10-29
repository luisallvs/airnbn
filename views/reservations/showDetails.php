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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">Reservation Details</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($reservation): ?>
                            <div class="mb-4">
                                <h3 class="text-primary"><?= htmlspecialchars($reservation['property_name']) ?></h3>
                                <p><strong>Address:</strong> <?= htmlspecialchars($reservation['property_address']) ?>, <?= htmlspecialchars($reservation['property_city']) ?></p>
                                <p><strong>Check-in:</strong> <?= htmlspecialchars($reservation['check_in']) ?></p>
                                <p><strong>Check-out:</strong> <?= htmlspecialchars($reservation['check_out']) ?></p>
                                <p><strong>Total Price:</strong> €<?= htmlspecialchars($reservation['total_price']) ?></p>
                            </div>

                            <!-- Status Section -->
                            <div class="d-flex justify-content-around mb-4">
                                <div class="text-center">
                                    <p class="mb-1"><strong>Payment Status</strong></p>
                                    <span class="badge <?= $reservation['is_paid'] ? 'bg-success' : 'bg-danger' ?> px-3 py-2">
                                        <?= $reservation['is_paid'] ? 'Paid' : 'Not Paid' ?>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <p class="mb-1"><strong>Reservation Status</strong></p>
                                    <span class="badge <?= $reservation['status'] === 'confirmed' ? 'bg-success' : ($reservation['status'] === 'pending' ? 'bg-warning' : 'bg-danger') ?> px-3 py-2">
                                        <?= ucfirst($reservation['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-column gap-3">
                                <!-- Pay Now Button (if not paid) -->
                                <?php if ($reservation['is_paid'] == 0): ?>
                                    <form action="<?= ROOT ?>/payments/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST" class="text-center">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->
                                        <button type="submit" class="btn btn-primary btn-lg">Pay Now</button>
                                    </form>
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->
                                <?php elseif ($reservation['is_paid'] == 1): ?>
                                    <p class="text-success text-center">Thank you! Your payment has been completed.</p>
                                <?php endif; ?>

                                <!-- Leave Review Button (if reservation is paid and completed) -->
                                <?php if ($reservation['is_paid'] && strtotime($reservation['check_out']) < time()): ?>
                                    <a href="<?= ROOT ?>/reviews/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" class="btn btn-warning btn-lg text-center">Leave a Review</a>
                                <?php endif; ?>

                                <a href="<?= ROOT ?>/reservations" class="btn btn-secondary btn-lg text-center">Back to Reservations</a>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center">Reservation not found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>