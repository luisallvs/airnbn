<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Property</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mb-5">
                    <div class="card-header bg-secondary text-white text-center">
                        <h2 class="mb-0">Edit Property</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= ROOT ?>/admin/properties/edit/<?= $property['property_id'] ?>" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                <!-- property name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Property Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($property['name']) ?>" required>
                                </div>

                                <!-- address -->
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($property['address']) ?>" required>
                                </div>

                                <!-- city -->
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($property['city']) ?>" required>
                                </div>

                                <!-- country -->
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" value="<?= htmlspecialchars($property['country']) ?>" required>
                                </div>

                                <!-- description -->
                                <div class="col-md-12 mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($property['description']) ?></textarea>
                                </div>

                                <!-- set availability -->
                                <div class="col-md-6 mb-3">
                                    <label for="availability_start" class="form-label">Availability Start</label>
                                    <input type="date" class="form-control" id="availability_start" name="availability_start" value="<?= htmlspecialchars($property['availability_start']) ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="availability_end" class="form-label">Availability End</label>
                                    <input type="date" class="form-control" id="availability_end" name="availability_end" value="<?= htmlspecialchars($property['availability_end']) ?>" required>
                                </div>

                                <!-- max guests -->
                                <div class="col-md-6 mb-3">
                                    <label for="max_guests" class="form-label">Max Guests</label>
                                    <input type="number" class="form-control" id="max_guests" name="max_guests" value="<?= htmlspecialchars($property['max_guests']) ?>" required>
                                </div>

                                <!-- price per night -->
                                <div class="col-md-6 mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night</label>
                                    <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="<?= htmlspecialchars($property['price_per_night']) ?>" required>
                                </div>
                            </div>

                            <!-- existing images -->
                            <h4 class="mt-4">Existing Images</h4>
                            <div class="row">
                                <?php foreach ($images as $image): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow-sm">
                                            <img src="<?= ROOT . $image['image_url'] ?>" class="card-img-top" alt="Property Image">
                                            <div class="card-body text-center">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="delete_images[]" value="<?= $image['images_id'] ?>"> Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- new images -->
                            <h4 class="mt-4">Upload New Images</h4>
                            <div class="mb-3">
                                <input type="file" name="property_images[]" class="form-control" accept=".jpg, .jpeg, .png, .webp, .avif" multiple>
                            </div>

                            <!-- submit and back buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                <a href="<?= ROOT ?>/admin/properties" class="btn btn-secondary btn-lg">Back to Properties</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>