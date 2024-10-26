<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Make a Reservation</title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h2>Reserve Your Stay at <?= htmlspecialchars($property['name']) ?></h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message) && !empty($message)): ?>
                            <div class="alert alert-warning text-center">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= ROOT ?>/reservations/create/<?= htmlspecialchars($property['property_id']) ?>" method="POST">
                            <!-- Check-in Date -->
                            <div class="mb-4">
                                <label for="check_in" class="form-label fw-bold">Check-in Date</label>
                                <input type="text" class="form-control" name="check_in" id="check_in" placeholder="Select check-in date" required>
                            </div>
                            <!-- Check-out Date -->
                            <div class="mb-4">
                                <label for="check_out" class="form-label fw-bold">Check-out Date</label>
                                <input type="text" class="form-control" name="check_out" id="check_out" placeholder="Select check-out date" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="/properties/showDetails/<?= htmlspecialchars($property['property_id']) ?>" class="btn btn-link">Go Back to Property Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass unavailable dates from PHP to JavaScript -->
    <script>
        const unavailableDates = <?= json_encode($unavailableDates) ?>;

        flatpickr("#check_in", {
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: "<?= $property['availability_end'] ?>",
            disable: unavailableDates,
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('check_out')._flatpickr.set('minDate', dateStr);
            }
        });

        flatpickr("#check_out", {
            dateFormat: "Y-m-d",
            minDate: "<?= $property['availability_start'] ?>",
            maxDate: "<?= $property['availability_end'] ?>",
            disable: unavailableDates
        });
    </script>
</body>

</html>