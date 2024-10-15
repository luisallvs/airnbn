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

    <div class="container mt-5">
        <h1 class="mb-4">Add a Property</h1>

        <form action="<?= ROOT ?>/properties/create" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Property Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>

            <div class="mb-3">
                <label for="price_per_night" class="form-label">Price per Night (€):</label>
                <input type="number" class="form-control" id="price_per_night" name="price_per_night" min="1" required>
            </div>

            <div class="mb-3">
                <label for="max_guests" class="form-label">Max Guests:</label>
                <input type="number" class="form-control" id="max_guests" name="max_guests" min="1" required>
            </div>

            <div class="mb-3">
                <label for="availability_start" class="form-label">Availability Start:</label>
                <input type="date" class="form-control" id="availability_start" name="availability_start" required>
            </div>

            <div class="mb-3">
                <label for="availability_end" class="form-label">Availability End:</label>
                <input type="date" class="form-control" id="availability_end" name="availability_end" required>
            </div>

            <div class="mb-3">
                <label for="property_images" class="form-label">Property Images:</label>
                <input type="file" class="form-control" id="property_images" name="property_images[]" multiple accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Property</button>
        </form>

        <div class="mt-4">
            <a href="<?= ROOT ?>/properties/manage" class="btn btn-secondary">Go Back</a>
        </div>
    </div>
</body>

</html>