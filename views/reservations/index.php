<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>My Reservations</h1>

    <?php if (!empty($reservations)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                        <td>$<?= htmlspecialchars($reservation['total_price']) ?></td>
                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                        <td><a href="<?= ROOT ?>/reservations/showDetails/<?= $reservation['reservation_id'] ?>">View Details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no reservations yet.</p>
    <?php endif; ?>
</body>

</html>