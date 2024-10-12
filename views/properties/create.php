<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add a Property</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Add a Property</h1>
    <form action="<?= ROOT ?>/properties/create" method="POST" enctype="multipart/form-data">
        <label>Property Name:</label>
        <input type="text" name="name" required><br>

        <label>Description:</label>
        <textarea name="description" required></textarea><br>

        <label>Address:</label>
        <input type="text" name="address" required><br>

        <label>City:</label>
        <input type="text" name="city" required><br>

        <label>Country:</label>
        <input type="text" name="country" required><br>

        <label>Price per Night:</label>
        <input type="number" name="price_per_night" required><br>

        <label>Max Guests:</label>
        <input type="number" name="max_guests" required><br>

        <label>Availability Start:</label>
        <input type="date" name="availability_start" required><br>

        <label>Availability End:</label>
        <input type="date" name="availability_end" required><br>

        <label>Propety Images:</label>
        <input type="file" name="property_images[]" multiple accept="image/*" required>

        <button type="submit">Add Property</button>
    </form>
</body>

</html>