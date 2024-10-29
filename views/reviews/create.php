<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Leave a Review for <?= htmlspecialchars($property['name']) ?></title>
</head>

<body>

    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="mb-0">Leave a Review for <?= htmlspecialchars($property['name']) ?></h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= ROOT ?>/reviews/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>"> <!-- CSRF token -->

                            <!-- Rating Section -->
                            <div class="mb-4">
                                <label for="rating" class="form-label"><strong>Rating (1-5):</strong></label>
                                <select name="rating" id="rating" class="form-select" required>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>

                            <!-- Comment Section -->
                            <div class="mb-4">
                                <label for="comment" class="form-label"><strong>Comment:</strong></label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Review</button>
                                <a href="<?= ROOT ?>/reservations/showDetails/<?= htmlspecialchars($reservation['reservation_id']) ?>" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>