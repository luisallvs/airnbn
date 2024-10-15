<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title><?= htmlspecialchars($property['name']) ?> - Property Details</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Property Info Section -->
            <div class="col-md-8">
                <h1><?= htmlspecialchars($property['name']) ?></h1>
                <p><strong>Description:</strong> <?= htmlspecialchars($property['description']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($property['address']) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($property['city']) ?></p>
                <p><strong>Country:</strong> <?= htmlspecialchars($property['country']) ?></p>
                <p><strong>Price per Night:</strong> €<?= htmlspecialchars($property['price_per_night']) ?></p>
                <p><strong>Max Guests:</strong> <?= htmlspecialchars($property['max_guests']) ?></p>
                <p><strong>Availability:</strong> <?= htmlspecialchars($property['availability_start']) ?> to <?= htmlspecialchars($property['availability_end']) ?></p>

                <div class="mt-4">
                    <!-- Edit Property Button -->
                    <a href="<?= ROOT ?>/properties/update/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-warning">Edit Property</a>

                    <!-- Delete Property Button -->
                    <form action="<?= ROOT ?>/properties/delete/<?= htmlspecialchars($property['property_id']) ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete Property</button>
                    </form>
                </div>
                <div class="mt-4">
                    <a href="<?= ROOT ?>/properties/manage" class="btn btn-secondary">Go Back</a>
                </div>
            </div>

            <!-- Property Images Section -->
            <div class="col-md-4">
                <h2>Photos</h2>
                <?php if (!empty($images)): ?>
                    <div class="row">
                        <?php foreach ($images as $image): ?>
                            <div class="col-md-6 mb-4">
                                <img src="<?= ROOT . htmlspecialchars($image['image_url']) ?>" class="img-fluid" alt="Property Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No photos available for this property.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back Button -->
    </div>
</body>

</html>