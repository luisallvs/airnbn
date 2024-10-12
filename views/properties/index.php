<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Properties</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Available Properties</h1>

    <?php if (!empty($properties)): ?>
        <table>
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Description</th>
                    <th>City</th>
                    <th>Price Per Night</th>
                    <th>Max Guests</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property): ?>
                    <tr>
                        <td><?= htmlspecialchars($property['name']) ?></td>
                        <td><?= htmlspecialchars(substr($property['description'], 0, 100)) ?>...</td>
                        <td><?= htmlspecialchars($property['city']) ?></td>
                        <td>$<?= htmlspecialchars($property['price_per_night']) ?></td>
                        <td><?= htmlspecialchars($property['max_guests']) ?></td>
                        <td>
                            <?= htmlspecialchars($property['availability_start']) ?> - <?= htmlspecialchars($property['availability_end']) ?>
                        </td>
                        <td>
                            <a href="<?= ROOT ?>/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>">View Details</a>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'guest'): ?>
                                <form action="<?= ROOT ?>/reservations/book" method="POST" style="display:inline;">
                                    <input type="hidden" name="property_id" value="<?= htmlspecialchars($property['property_id']) ?>">
                                    <button type="submit">Book Now</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No properties are available at the moment.</p>
    <?php endif; ?>
</body>

</html>