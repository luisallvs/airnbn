<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Properties</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>My Properties</h1>

    <?php if (!empty($properties)): ?>
        <ul>
            <?php foreach ($properties as $property): ?>
                <li>
                    <h2><?= htmlspecialchars($property['name']) ?></h2>
                    <p><?= htmlspecialchars($property['description']) ?></p>
                    <p><strong>Price:</strong> $<?= htmlspecialchars($property['price_per_night']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($property['city']) ?>, <?= htmlspecialchars($property['country']) ?></p>
                    <a href="<?= ROOT ?>/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>">View Details</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have not listed any properties yet.</p>
    <?php endif; ?>
</body>

</html>