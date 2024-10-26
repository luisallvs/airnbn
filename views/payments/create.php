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
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h3 class="mb-0">Complete Your Payment</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= ROOT ?>/payments/submit/<?= htmlspecialchars($reservation_id) ?>" method="POST">
                            <div class="mb-4">
                                <label for="method" class="form-label"><strong>Select Payment Method:</strong></label>
                                <select name="method_id" class="form-select" required>
                                    <option value="" disabled selected>-- Select Payment Method --</option>
                                    <?php foreach ($paymentMethods as $method): ?>
                                        <option value="<?= htmlspecialchars($method['method_id']) ?>"><?= htmlspecialchars($method['method_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4 text-center">
                                <p class="lead mb-1"><strong>Total Amount Due:</strong></p>
                                <p class="display-6 text-success">€<?= htmlspecialchars($reservation['total_price']) ?></p>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Submit Payment</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <a href="<?= ROOT ?>/reservations/showDetails/<?= htmlspecialchars($reservation_id) ?>" class="btn btn-secondary">Back to Reservation</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>