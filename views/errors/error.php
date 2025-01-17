<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Error - <?= htmlspecialchars($errorCode) ?></title>
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5 text-center">
        <h1 class="display-1 text-danger"><?= htmlspecialchars($errorCode) ?></h1>
        <h2 class="mb-4"><?= htmlspecialchars_decode($errorMessage) ?></h2>

        <!-- Updated Go Home button with corrected ROOT syntax -->
        <a href="/" class="btn btn-primary">Go Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>