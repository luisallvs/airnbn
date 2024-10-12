<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <h1>Make Payment for Reservation #<?= htmlspecialchars($reservation_id) ?></h1>

    <form action="<?= ROOT ?>/payments/submit/<?= htmlspecialchars($reservation_id) ?>" method="POST">
        <label for="method">Select Payment Method:</label>
        <select name="method_id" required>
            <?php foreach ($methods as $method): ?>
                <option value="<?= htmlspecialchars($method['method_id']) ?>"><?= htmlspecialchars($method['method_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <p>Total Amount: $<?= htmlspecialchars($reservation['total_price']) ?></p>

        <button type="submit">Submit Payment</button>
    </form>
</body>

</html>