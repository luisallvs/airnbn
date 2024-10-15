<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Make a Reservation</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4 text-center">Make a Reservation for <?= htmlspecialchars($property['name']) ?></h1>

                <?php if (isset($message) && !empty($message)): ?>
                    <div class="alert alert-warning">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-center align-items-center mt-5">
                    <div class="col-md-4 text-center">
                        <form action="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>" method="POST">
                            <div class="mb-3">
                                <label for="check_in" class="form-label h4">Check-in Date</label>
                                <input type="date" class="form-control form-control-sm" name="check_in" id="check_in"
                                    min="<?= htmlspecialchars($property['availability_start']) ?>"
                                    max="<?= htmlspecialchars($property['availability_end']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="check_out" class="form-label h4">Check-out Date</label>
                                <input type="date" class="form-control form-control-sm" name="check_out" id="check_out"
                                    min="<?= htmlspecialchars($property['availability_start']) ?>"
                                    max="<?= htmlspecialchars($property['availability_end']) ?>" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-sm">Book Now</button>
                            </div>
                        </form>
                        <div class="mt-3 d-grid">
                            <a href="<?= ROOT ?>/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-secondary btn-sm">Go Back</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>