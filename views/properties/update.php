<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Edit Property - <?= htmlspecialchars($property['name']) ?></title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h2>Edit Property: <?= htmlspecialchars($property['name']) ?></h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= ROOT ?>/properties/update/<?= htmlspecialchars($property['property_id']) ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->

                            <!-- Basic Info Section -->
                            <h4 class="mb-3">Basic Information</h4>
                            <div class="mb-3">
                                <label for="name" class="form-label">Property Name:</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($property['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($property['description']) ?></textarea>
                            </div>

                            <!-- Location Section -->
                            <h4 class="mb-3">Location</h4>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($property['address']) ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City:</label>
                                    <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($property['city']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country:</label>
                                    <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($property['country']) ?>" required>
                                </div>
                            </div>

                            <!-- Pricing and Capacity Section -->
                            <h4 class="mb-3">Pricing and Capacity</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night (€):</label>
                                    <input type="number" name="price_per_night" class="form-control" value="<?= htmlspecialchars($property['price_per_night']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="max_guests" class="form-label">Max Guests:</label>
                                    <input type="number" name="max_guests" class="form-control" value="<?= htmlspecialchars($property['max_guests']) ?>" required>
                                </div>
                            </div>

                            <!-- Availability Section -->
                            <h4 class="mb-3">Availability</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="availability_start" class="form-label">Start Date:</label>
                                    <input type="date" name="availability_start" class="form-control" value="<?= htmlspecialchars($property['availability_start']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="availability_end" class="form-label">End Date:</label>
                                    <input type="date" name="availability_end" class="form-control" value="<?= htmlspecialchars($property['availability_end']) ?>" required>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <h4 class="mb-3">Images</h4>
                            <h5 class="text-secondary">Existing Images</h5>
                            <div class="row mb-4">
                                <?php if (!empty($images)): ?>
                                    <?php foreach ($images as $image): ?>
                                        <div class="col-md-4">
                                            <div class="card mb-3">
                                                <img src="<?= ROOT . htmlspecialchars($image['image_url']) ?>" class="card-img-top" alt="Property Image" style="height: 200px; object-fit: cover;">
                                                <div class="card-body text-center">
                                                    <label>
                                                        <input type="checkbox" name="delete_images[]" value="<?= htmlspecialchars($image['images_id']) ?>"> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No images found for this property.</p>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="property_images" class="form-label">Upload New Images:</label>
                                <input type="file" name="property_images[]" class="form-control" multiple accept="image/*">
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                <a href="<?= ROOT ?>/properties/manageSingle/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>