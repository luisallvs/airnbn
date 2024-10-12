<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Reservation Details</h1>

    <?php if ($reservation): ?>
        <h2><?= htmlspecialchars($reservation['property_name']) ?></h2>
        <p><strong>Address:</strong> <?= htmlspecialchars($reservation['property_address']) ?>, <?= htmlspecialchars($reservation['property_city']) ?></p>
        <p><strong>Check-in:</strong> <?= htmlspecialchars($reservation['check_in']) ?></p>
        <p><strong>Check-out:</strong> <?= htmlspecialchars($reservation['check_out']) ?></p>
        <p><strong>Total Price:</strong> $<?= htmlspecialchars($reservation['total_price']) ?></p>
        <p>Payment Status: <?= $reservation['is_paid'] ? 'Paid' : 'Not Paid' ?></p>

        <?php if ($reservation['is_paid'] == 0 && $reservation['status'] === 'confirmed'): ?>
            <!-- show the Pay Now button if the reservation is confirmed but not paid -->
            <form action="<?= ROOT ?>/payments/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
                <button type="submit">Pay Now</button>
            </form>
        <?php elseif ($reservation['is_paid'] == 1): ?>
            <!-- payment has already been made -->
            <p>Thank you! Your payment has been completed.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Reservation not found.</p>
    <?php endif; ?>
</body>

</html>