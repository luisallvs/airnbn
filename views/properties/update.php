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

    <div class="container mt-4">
        <h1>Edit Property: <?= htmlspecialchars($property['name']) ?></h1>

        <form action="<?= ROOT ?>/properties/update/<?= htmlspecialchars($property['property_id']) ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Property Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($property['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($property['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($property['address']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($property['city']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($property['country']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="price_per_night" class="form-label">Price per Night (€):</label>
                <input type="number" name="price_per_night" class="form-control" value="<?= htmlspecialchars($property['price_per_night']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="max_guests" class="form-label">Max Guests:</label>
                <input type="number" name="max_guests" class="form-control" value="<?= htmlspecialchars($property['max_guests']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="availability_start" class="form-label">Availability Start:</label>
                <input type="date" name="availability_start" class="form-control" value="<?= htmlspecialchars($property['availability_start']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="availability_end" class="form-label">Availability End:</label>
                <input type="date" name="availability_end" class="form-control" value="<?= htmlspecialchars($property['availability_end']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?= ROOT ?>/properties/manageSingle/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>