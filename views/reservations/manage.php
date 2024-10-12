<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Reservations</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Manage Reservations</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (!empty($_GET['message'])): ?>
        <p><?= htmlspecialchars($_GET['message']) ?></p>
    <?php endif; ?>

    <?php if (!empty($reservations)): ?>
        <table>
            <thead>
                <tr>
                    <th>Property</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                        <td><?= htmlspecialchars($reservation['total_price']) ?></td>
                        <td><?= htmlspecialchars($reservation['status']) ?></td>
                        <td>
                            <?php if ($reservation['status'] === 'pending'): ?>
                                <form action="<?= ROOT ?>/reservations/confirm/<?= $reservation['reservation_id'] ?>" method="POST" style="display:inline;">
                                    <button type="submit">Confirm</button>
                                </form>
                                <form action="<?= ROOT ?>/reservations/cancel/<?= $reservation['reservation_id'] ?>" method="POST" style="display:inline;">
                                    <button type="submit">Cancel</button>
                                </form>
                            <?php else: ?>
                                <span><?= ucfirst($reservation['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No reservations available for your properties.</p>
    <?php endif; ?>
</body>

</html>