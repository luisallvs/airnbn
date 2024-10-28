<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Add a Property</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">Add a New Property</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= ROOT ?>/properties/create" method="POST" enctype="multipart/form-data">

                            <!-- Property Details Section -->
                            <h4 class="mb-3">Property Details</h4>
                            <div class="mb-3">
                                <label for="name" class="form-label">Property Name:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter property name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Provide a brief description" required></textarea>
                            </div>

                            <!-- Location Section -->
                            <h4 class="mt-4 mb-3">Location</h4>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City:</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country:</label>
                                    <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" required>
                                </div>
                            </div>

                            <!-- Pricing and Capacity Section -->
                            <h4 class="mt-4 mb-3">Pricing and Capacity</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night (€):</label>
                                    <input type="number" class="form-control" id="price_per_night" name="price_per_night" min="1" placeholder="€0.00" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="max_guests" class="form-label">Max Guests:</label>
                                    <input type="number" class="form-control" id="max_guests" name="max_guests" min="1" placeholder="Enter max guests" required>
                                </div>
                            </div>

                            <!-- Availability Section -->
                            <h4 class="mt-4 mb-3">Availability</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="availability_start" class="form-label">Start Date:</label>
                                    <input type="date" class="form-control" id="availability_start" name="availability_start" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="availability_end" class="form-label">End Date:</label>
                                    <input type="date" class="form-control" id="availability_end" name="availability_end" required>
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <h4 class="mt-4 mb-3">Property Images</h4>
                            <div class="mb-3">
                                <label for="property_images" class="form-label">Upload Images:</label>
                                <input type="file" class="form-control" id="property_images" name="property_images[]" multiple accept="image/*" required>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Add Property</button>
                                <a href="<?= ROOT ?>/properties/manage" class="btn btn-secondary btn-lg">Go Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>