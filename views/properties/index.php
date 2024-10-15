<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Available Properties</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Available Properties</h1>

        <?php if (!empty($properties)): ?>
            <div class="row">
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow">
                            <!-- Display property image from the property_images table, use placeholder if no image is available -->
                            <img src="<?= ROOT . htmlspecialchars($property['image_url'] ?? 'https://via.placeholder.com/300x200') ?>"
                                class="card-img-top" alt="Property Image" style="height: 200px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($property['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($property['description'], 0, 100)) ?>...</p>
                                <p class="card-text"><strong>Price:</strong> €<?= htmlspecialchars($property['price_per_night']) ?> / night</p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($property['city']) ?></p>
                                <p class="card-text"><strong>Max Guests:</strong> <?= htmlspecialchars($property['max_guests']) ?></p>
                                <p class="card-text"><strong>Availability:</strong> <?= htmlspecialchars($property['availability_start']) ?> - <?= htmlspecialchars($property['availability_end']) ?></p>
                                <a href="<?= ROOT ?>/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No properties available at the moment.</p>
        <?php endif; ?>
    </div>
</body>

</html>