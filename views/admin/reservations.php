<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT ?>/js/admin/updateStatus.js"></script>
    <script src="<?= ROOT ?>/js/admin/updateIsPaid.js"></script>
    <title>All Reservations</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">

        <h1 class="text-center mb-4">All Reservations</h1>
        <div class="d-flex flex-row justify-content-between">

            <!-- create reservation button -->
            <div class="d-flex justify-content-start mb-2">
                <a href="<?= ROOT ?>/admin/reservations/create" class="btn btn-primary">Create Reservation</a>
            </div>

            <!-- back to dashboard button -->
            <div class="d-flex justify-content-start mb-2">
                <a href="<?= ROOT ?>/admin/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <!-- reservations table -->
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Reservation ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Property</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Is Paid</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allReservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                        <td><?= htmlspecialchars($reservation['user_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['property_name']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_in']) ?></td>
                        <td><?= htmlspecialchars($reservation['check_out']) ?></td>
                        <td>
                            <button class="btn toggle-paid-status <?= $reservation['is_paid'] == '1' ? 'btn-success' : 'btn-danger' ?>"
                                data-id="<?= $reservation['reservation_id'] ?>"
                                data-paid="<?= $reservation['is_paid'] ?>">
                                <?= $reservation['is_paid'] == '1' ? 'Paid' : 'Not Paid' ?>
                            </button>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm <?= $reservation['status'] === 'confirmed' ? 'btn-success' : 'btn-outline-success' ?>"
                                    data-status="confirmed" data-id="<?= $reservation['reservation_id'] ?>">Confirmed</button>
                                <button class="btn btn-sm <?= $reservation['status'] === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>"
                                    data-status="pending" data-id="<?= $reservation['reservation_id'] ?>">Pending</button>
                                <button class="btn btn-sm <?= $reservation['status'] === 'canceled' ? 'btn-danger' : 'btn-outline-danger' ?>"
                                    data-status="canceled" data-id="<?= $reservation['reservation_id'] ?>">Canceled</button>
                            </div>
                        </td>

                        <td class="text-center">
                            <a href="<?= ROOT ?>/admin/reservations/edit/<?= $reservation['reservation_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= ROOT ?>/admin/reservations/delete/<?= $reservation['reservation_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>