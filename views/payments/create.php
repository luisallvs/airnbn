<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Make Payment</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Make the Payment for Your Reservation</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= ROOT ?>/payments/submit/<?= htmlspecialchars($reservation_id) ?>" method="POST">
                    <div class="mb-3">
                        <label for="method" class="form-label">Select Payment Method:</label>
                        <select name="method_id" class="form-select" required>
                            <?php foreach ($paymentMethods as $method): ?>
                                <option value="<?= htmlspecialchars($method['method_id']) ?>"><?= htmlspecialchars($method['method_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <p class="lead"><strong>Total Amount:</strong> €<?= htmlspecialchars($reservation['total_price']) ?></p>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>