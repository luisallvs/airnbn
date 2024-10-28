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
        <div class="row justify-content-center">
            <!-- Property Details (Left Column) -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
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

                        <div class="d-grid gap-2 mt-4">
                            <a href="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-success btn-lg">Book Now</a>
                            <a href="<?= ROOT ?>/messages/conversation/<?= htmlspecialchars($property['user_id']) ?>/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-outline-primary btn-lg">Message Host</a>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="card shadow-sm mt-4 mb-4">
                    <div class="card-header bg-secondary text-white text-center">
                        <h3 class="mb-0">Reviews</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="border-bottom pb-3 mb-3">
                                    <p class="mb-1"><strong>Comment:</strong> <?= htmlspecialchars($review['comment']) ?></p>
                                    <p class="mb-1"><strong>Rating:</strong> <?= htmlspecialchars($review['rating']) ?> / 5</p>
                                    <p class="text-muted mb-0"><em>Reviewed by <?= htmlspecialchars($review['reviewer_name']) ?> on <?= htmlspecialchars($review['created_at']) ?></em></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No reviews available for this property.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Property Images Carousel (Right Column) -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white text-center">
                        <h3 class="mb-0">Photos</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($images)): ?>
                            <div id="propertyImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($images as $index => $image): ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= ROOT . htmlspecialchars($image['image_url']) ?>" class="d-block w-100 rounded img-fluid" alt="Property Image">
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
                            <p class="text-muted text-center">No photos available for this property.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>