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

    <div class="container mt-5 mb-5">
        <div class="row g-4">
            <!-- Property Info Section -->
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0"><?= htmlspecialchars($property['name']) ?></h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Description:</strong> <?= htmlspecialchars($property['description']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($property['address']) ?></p>
                        <p><strong>City:</strong> <?= htmlspecialchars($property['city']) ?></p>
                        <p><strong>Country:</strong> <?= htmlspecialchars($property['country']) ?></p>
                        <p><strong>Price per Night:</strong> €<?= htmlspecialchars($property['price_per_night']) ?></p>
                        <p><strong>Max Guests:</strong> <?= htmlspecialchars($property['max_guests']) ?></p>
                        <p><strong>Availability:</strong> <?= htmlspecialchars($property['availability_start']) ?> to <?= htmlspecialchars($property['availability_end']) ?></p>

                        <div class="d-grid gap-3 mt-4">
                            <!-- Edit Property Button -->
                            <a href="<?= ROOT ?>/properties/update/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-warning btn-lg w-100">Edit Property</a>

                            <!-- Delete Property Button -->
                            <form action="<?= ROOT ?>/properties/delete/<?= htmlspecialchars($property['property_id']) ?>" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->
                                <button type="submit" class="btn btn-outline-danger btn-lg w-100" onclick="return confirm('Are you sure you want to delete this property?')">Delete Property</button>
                            </form>

                            <!-- Go Back Button -->
                            <a href="<?= ROOT ?>/properties/manage" class="btn btn-secondary btn-lg w-100 mt-3">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Images Section -->
            <div class="col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-secondary text-white text-center">
                        <h4 class="mb-0">Photos</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($images)): ?>
                            <div class="row row-cols-2 g-2">
                                <?php foreach ($images as $image): ?>
                                    <div class="col">
                                        <img src="<?= ROOT . htmlspecialchars($image['image_url']) ?>" class="img-fluid rounded shadow-sm" alt="Property Image">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center mt-3">No photos available for this property.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>