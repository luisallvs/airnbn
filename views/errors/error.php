<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= http_response_code() ?></title>
</head>

<body>
    <h1>Error <?= http_response_code() ?></h1>
    <p><?= htmlspecialchars($message) ?></p>
    <p><a href="<?= ROOT ?>/">Go back to Home</a></p>
</body>

</html>