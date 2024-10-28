<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Airnbn</title>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Welcome to Airnbn</h1>

        <h2 class="text-center">
            Hello
            <?php if (isset($_SESSION['user_name'])): ?>
                <?= htmlspecialchars($_SESSION['user_name']) ?>!
            <?php endif; ?>
        </h2>

        <!-- Properties Section -->
        <h3 class="mb-4">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'host'): ?>
                Your Listed Properties
            <?php else: ?>
                All Available Properties
            <?php endif; ?>
        </h3>

        <div class="row">
            <?php if (!empty($properties)): ?>
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow">
                            <img src="<?= ROOT . htmlspecialchars($property['image_url'] ?? 'https://via.placeholder.com/300x200') ?>" class="card-img-top" alt="Property Image" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($property['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($property['description'], 0, 150)) ?>...</p>
                                <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($property['price_per_night']) ?> €/night</p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($property['city']) ?>, <?= htmlspecialchars($property['country']) ?></p>
                                <a href="<?= ROOT ?>/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'host'): ?>
                        You have no properties listed.
                    <?php else: ?>
                        No properties available at the moment.
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>