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
                                Confirmed
                            <?php elseif ($reservation['status'] === 'canceled'): ?>
                                Canceled
                            <?php else: ?>
                                Pending
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($reservation['is_paid'] ? 'Paid' : 'Not Paid') ?></td>
                        <td>
                            <?php if ($reservation['status'] === 'pending'): ?>
                                <form action="<?= ROOT ?>/reservations/confirm/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
                                    <button type="submit">Confirm</button>
                                </form>
                                <form action="<?= ROOT ?>/reservations/cancel/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
                                    <button type="submit">Cancel</button>
                                </form>
                            <?php else: ?>
                                <?= ucfirst(htmlspecialchars($reservation['status'])) ?>
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