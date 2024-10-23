<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Create New Reservation</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-secondary text-white text-center">
                <h2>Create New Reservation</h2>
            </div>

            <div class="card-body">
                <form action="<?= ROOT ?>/admin/reservations/create" method="POST">
                    <div class="row">
                        <!-- user dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['user_id'] ?>"><?= $user['name'] ?> (ID: <?= $user['user_id'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- property dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="property_id" class="form-label">Select Property</label>
                            <select name="property_id" class="form-select" required>
                                <option value="">Select Property</option>
                                <?php foreach ($properties as $property): ?>
                                    <option value="<?= $property['property_id'] ?>"><?= $property['name'] ?> (ID: <?= $property['property_id'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- check-in -->
                        <div class="col-md-6 mb-3">
                            <label for="check_in" class="form-label">Check-In Date</label>
                            <input type="date" name="check_in" class="form-control" required>
                        </div>

                        <!-- check-out -->
                        <div class="col-md-6 mb-3">
                            <label for="check_out" class="form-label">Check-Out Date</label>
                            <input type="date" name="check_out" class="form-control" required>
                        </div>

                        <!-- total price -->
                        <div class="col-md-6 mb-3">
                            <label for="total_price" class="form-label">Total Price</label>
                            <input type="number" name="total_price" class="form-control" step="0.01" required>
                        </div>

                        <!-- status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>

                        <!-- is paid -->
                        <div class="col-md-6 mb-3">
                            <label for="is_paid" class="form-label">Is Paid?</label>
                            <select name="is_paid" class="form-select">
                                <option value="0">Not Paid</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>
                    </div>

                    <!-- submit and back buttons -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success me-3">Create Reservation</button>
                        <a href="<?= ROOT ?>/admin/reservations" class="btn btn-secondary">Back to Reservations</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>