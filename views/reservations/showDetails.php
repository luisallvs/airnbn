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
        <p>Address: <?= htmlspecialchars($reservation['property_address']) ?>, <?= htmlspecialchars($reservation['property_city']) ?></p>
        <p>Check-in: <?= htmlspecialchars($reservation['check_in']) ?></p>
        <p>Check-out: <?= htmlspecialchars($reservation['check_out']) ?></p>
        <p>Total Price: $<?= htmlspecialchars($reservation['total_price']) ?></p>
        <p>Status: <?= htmlspecialchars($reservation['status']) ?></p>
        <p>Payment Status: <?= htmlspecialchars($isPaid) ?></p>

        <?php if ($reservation['status'] === 'pending'): ?>
            <form action="<?= ROOT ?>/reservations/cancel/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
                <button type="submit">Cancel Reservation</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>Reservation not found.</p>
    <?php endif; ?>
</body>

</html>