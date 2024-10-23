<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Edit Reservation</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-secondary text-white text-center">
                        <h2 class="mb-0">Edit Reservation</h2>
                    </div>
                    <div class="card-body p-4">

                        <form action="" method="POST">

                            <!-- check in date -->
                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check In:</label>
                                <input type="date" name="check_in" class="form-control" value="<?= htmlspecialchars($reservation['check_in']) ?>" required>
                            </div>

                            <!-- check out date -->
                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check Out:</label>
                                <input type="date" name="check_out" class="form-control" value="<?= htmlspecialchars($reservation['check_out']) ?>" required>
                            </div>

                            <!-- submit and back buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">Update Reservation</button>
                                <a href="<?= ROOT ?>/admin/reservations" class="btn btn-secondary btn-lg">Back to Reservations</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>