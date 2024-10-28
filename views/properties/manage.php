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

    <div class="container mt-5">
        <h1 class="text-center mb-4">My Properties</h1>

        <?php if (!empty($properties)): ?>
            <div class="row g-4 mb-4">
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header bg-dark text-white text-center">
                                <h5 class="mb-0"><?= htmlspecialchars($property['name']) ?></h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($property['description'], 0, 100)) ?>...</p>
                                <p class="card-text"><strong>Price:</strong> €<?= htmlspecialchars(number_format($property['price_per_night'], 2)) ?> /night</p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($property['city']) ?>, <?= htmlspecialchars($property['country']) ?></p>
                                <div class="mt-auto text-center">
                                    <a href="<?= ROOT ?>/properties/manageSingle/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center mt-4" role="alert">
                You have not listed any properties yet.
            </div>
        <?php endif; ?>
    </div>
</body>

</html>