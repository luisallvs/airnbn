<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Make a Reservation for <?= htmlspecialchars($property['name']) ?></h1>

    <?php if (isset($message) && !empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>" method="POST">
        <label for="check_in">Check-in:</label>
        <input
            type="date"
            name="check_in"
            min="<?= htmlspecialchars($property['availability_start']) ?>"
            max="<?= htmlspecialchars($property['availability_end']) ?>"
            required>

        <label for="check_out">Check-out:</label>
        <input
            type="date"
            name="check_out"
            min="<?= htmlspecialchars($property['availability_start']) ?>"
            max="<?= htmlspecialchars($property['availability_end']) ?>"
            required>

        <button type="submit">Book Now</button>
    </form>
</body>

</html>