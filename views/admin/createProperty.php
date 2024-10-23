<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create Property</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-secondary text-white text-center">
                        <h2 class="mb-0">Create Property</h2>
                    </div>
                    <div class="card-body p-4">

                        <!-- form -->
                        <form action="<?= ROOT ?>/admin/properties/create" method="POST" enctype="multipart/form-data">

                            <!-- property owner id -->
                            <div class="mb-3">
                                <label for="owner_id" class="form-label">Property Owner ID:</label>
                                <input type="number" name="owner_id" class="form-control" placeholder="Enter owner ID" required>
                            </div>

                            <!-- property name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Property Name:</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter property name" required>
                            </div>

                            <!-- property description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Enter property description" required></textarea>
                            </div>

                            <div class="row">

                                <!-- property address -->
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter property address" required>
                                </div>

                                <!-- property city -->
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City:</label>
                                    <input type="text" name="city" class="form-control" placeholder="Enter city" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- property country -->
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country:</label>
                                    <input type="text" name="country" class="form-control" placeholder="Enter country" required>
                                </div>

                                <!-- max guests -->
                                <div class="col-md-6 mb-3">
                                    <label for="max_guests" class="form-label">Maximum Guests:</label>
                                    <input type="number" name="max_guests" class="form-control" placeholder="Enter max guests" required>
                                </div>
                            </div>

                            <!-- availability -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="availability_start" class="form-label">Availability Start Date:</label>
                                    <input type="date" name="availability_start" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="availability_end" class="form-label">Availability End Date:</label>
                                    <input type="date" name="availability_end" class="form-control" required>
                                </div>
                            </div>

                            <!-- price per night -->
                            <div class="mb-3">
                                <label for="price_per_night" class="form-label">Price per Night:</label>
                                <input type="number" name="price_per_night" class="form-control" placeholder="Enter price per night" required>
                            </div>

                            <!-- property images -->
                            <div class="mb-3">
                                <label for="property_images" class="form-label">Upload Property Images:</label>
                                <input type="file" name="property_images[]" class="form-control" multiple>
                            </div>

                            <!-- submit and back buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-success">Create Property</button>
                                <a href="<?= ROOT ?>/admin/properties" class="btn btn-secondary">Back to Properties</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>