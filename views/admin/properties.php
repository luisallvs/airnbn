<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>All Properties</title>
</head>

<body>

    <!-- Navbar -->
    <?php include __DIR__ . '/templates/navbar.php'; ?>

    <div class="container mt-5">

        <h1 class="text-center mb-4">All Properties</h1>
        <div class="d-flex flex-row justify-content-between">

            <!-- create property button -->
            <div class="d-flex justify-content- mb-2">
                <a href="<?= ROOT ?>/admin/properties/create" class="btn btn-primary">Create Property</a>
            </div>

            <!-- back to dashboard button -->
            <div class="d-flex justify-content-start mb-2">
                <a href="/" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <!-- properties table -->
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Property ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Price per Night</th>
                    <th scope="col">Created At</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allProperties as $property): ?>
                    <tr>
                        <td><?= htmlspecialchars($property['property_id']) ?></td>
                        <td><?= htmlspecialchars($property['name']) ?></td>
                        <td><?= htmlspecialchars($property['owner_name']) ?></td>
                        <td><?= htmlspecialchars($property['price_per_night']) ?></td>
                        <td><?= htmlspecialchars($property['created_at']) ?></td>
                        <td class="text-center">
                            <a href="<?= ROOT ?>/admin/properties/edit/<?= $property['property_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= ROOT ?>/admin/properties/delete/<?= $property['property_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>