<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>My Properties</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">My Properties</h1>

        <?php if (!empty($properties)): ?>
            <div class="row">
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($property['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($property['description']) ?></p>
                                <p class="card-text"><strong>Price per Night:</strong> $<?= htmlspecialchars($property['price_per_night']) ?></p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($property['city']) ?>, <?= htmlspecialchars($property['country']) ?></p>
                                <a href="<?= ROOT ?>/properties/manageSingle/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                You have not listed any properties yet.
            </div>
        <?php endif; ?>
    </div>

</body>

</html>