<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($property['name']) ?> - Property Details</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1><?= htmlspecialchars($property['name']) ?></h1>
    <p><strong>Description:</strong> <?= htmlspecialchars($property['description']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($property['address']) ?></p>
    <p><strong>City:</strong> <?= htmlspecialchars($property['city']) ?></p>
    <p><strong>Country:</strong> <?= htmlspecialchars($property['country']) ?></p>
    <p><strong>Price per Night:</strong> $<?= htmlspecialchars($property['price_per_night']) ?></p>
    <p><strong>Max Guests:</strong> <?= htmlspecialchars($property['max_guests']) ?></p>
    <p><strong>Availability:</strong> <?= htmlspecialchars($property['availability_start']) ?> to <?= htmlspecialchars($property['availability_end']) ?></p>

    <h2>Photos</h2>
    <?php if (!empty($images)): ?>
        <div>
            <?php foreach ($images as $imageUrl): ?>
                <img src="<?= ROOT . htmlspecialchars($imageUrl) ?>" alt="Property Image" style="max-width: 300px; max-height: 200px; margin: 5px;">
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No photos available for this property.</p>
    <?php endif; ?>

    <a href="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>">Book Now</a>
</body>

</html>