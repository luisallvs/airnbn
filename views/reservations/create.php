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
                                <input type="text" class="form-control form-control-sm" name="check_in" id="check_in" required>
                            </div>

                            <div class="mb-3">
                                <label for="check_out" class="form-label h4">Check-out Date</label>
                                <input type="text" class="form-control form-control-sm" name="check_out" id="check_out" required>
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