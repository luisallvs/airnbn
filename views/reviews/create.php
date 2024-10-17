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
    <div class="container mt-5">
        <h1 class="text-center">Leave a Review for <?= htmlspecialchars($property['name']) ?></h1>

        <form action="<?= ROOT ?>/reviews/create/<?= htmlspecialchars($reservation['reservation_id']) ?>" method="POST">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5):</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Very Good</option>
                    <option value="3">3 - Good</option>
                    <option value="2">2 - Fair</option>
                    <option value="1">1 - Poor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment:</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
            <a href="<?= ROOT ?>/reservations/showDetails/<?= htmlspecialchars($reservation['reservation_id']) ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>