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

    <div class="container mt-5">
        <div class="row">
            <!-- Property Details (Left Column) -->
            <div class="col-md-6">
                <h1 class="mb-4"><?= htmlspecialchars($property['name']) ?></h1>
                <p><strong>Description:</strong> <?= htmlspecialchars($property['description']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($property['address']) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($property['city']) ?></p>
                <p><strong>Country:</strong> <?= htmlspecialchars($property['country']) ?></p>
                <p><strong>Price per Night:</strong> €<?= htmlspecialchars($property['price_per_night']) ?></p>
                <p><strong>Max Guests:</strong> <?= htmlspecialchars($property['max_guests']) ?></p>
                <p><strong>Availability:</strong> <?= htmlspecialchars($property['availability_start']) ?> to <?= htmlspecialchars($property['availability_end']) ?></p>

                <a href="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-primary">Book Now</a>

                <div class="mt-4">
                    <a href="<?= ROOT ?>/properties" class="btn btn-secondary">Go Back</a>
                </div>

                <!-- Reviews Section (Below Buttons) -->
                <h2 class="mt-5">Reviews</h2>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="card-text"><?= htmlspecialchars($review['comment']) ?></p>
                                <p class="card-text"><strong>Rating:</strong> <?= htmlspecialchars($review['rating']) ?> / 5</p>
                                <p class="card-text"><em>Reviewed by <?= htmlspecialchars($review['reviewer_name']) ?> on <?= htmlspecialchars($review['created_at']) ?></em></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No reviews available for this property.</p>
                <?php endif; ?>
            </div>

            <!-- Property Images Carousel (Right Column) -->
            <div class="col-md-6">
                <h2>Photos</h2>
                <?php if (!empty($images)): ?>
                    <div id="propertyImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= ROOT . htmlspecialchars($image['image_url']) ?>" class="d-block w-100 img-fluid" alt="Property Image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertyImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No photos available for this property.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>