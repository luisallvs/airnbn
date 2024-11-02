<?php

require_once 'models/reservations.php';
require_once 'models/properties.php';
require_once 'models/payments.php';
require_once 'models/paymentMethods.php';

require_once 'controllers/utils/csrf_utils.php';

/* fucntion to list users reservations */

function index()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to view your reservations.';
        require 'views/errors/error.php';
        return;
    }

    $model = new Reservations();

    $user_id = $_SESSION['user_id'];
    $reservations = $model->getReservationsByUser($user_id);

    http_response_code(200);
    require 'views/reservations/index.php';
}


/* function to create a new reservation */

function create($property_id)
{
    /* Make sure user is logged in */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'guest') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a guest to make a reservation.';
        require 'views/errors/error.php';
        return;
    }

    $model = new Reservations();
    $propertyModel = new Properties();
    $property = $propertyModel->getById($property_id);

    if (!$property) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Property not found.';
        require 'views/errors/error.php';
        return;
    }

    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    /* fetch unavailable dates */
    $reservationModel = new Reservations();
    $reservations = $reservationModel->getReservationsByProperty($property_id);

    $unavailableDates = [];
    foreach ($reservations as $reservation) {
        $period = new DatePeriod(
            new DateTime($reservation['check_in']),
            new DateInterval('P1D'),
            new DateTime($reservation['check_out'])
        );

        foreach ($period as $date) {
            $unavailableDates[] = $date->format('Y-m-d');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        $checkIn = $_POST['check_in'] ?? "";
        $checkOut = $_POST['check_out'] ?? "";

        /* get today's date */
        $today = date('Y-m-d');

        /* validate dates */
        if (empty($checkIn) || empty($checkOut)) {
            http_response_code(400);
            $message = "Check-in and check-out dates cannot be empty.";
            require 'views/reservations/create.php';
            return;
        }

        if (strtotime($checkIn) >= strtotime($checkOut)) {
            http_response_code(400);
            $message = "Invalid dates. Please ensure the check-out date is after the check-in date.";
            require 'views/reservations/create.php';
            return;
        }

        /* Ensure the check-in date is within the property's available range */
        if (strtotime($checkIn) > strtotime($property['availability_end']) || strtotime($checkOut) > strtotime($property['availability_end'])) {
            http_response_code(400);
            $message = "The selected dates are beyond the property's availability.";
            require 'views/reservations/create.php';
            return;
        }

        /* check if the check in dates is in the past */
        if (strtotime($checkIn) < strtotime($today)) {
            http_response_code(400);
            $message = "You cannot book a reservation in the past. Please select a valid date.";
            require 'views/reservations/create.php';
            return;
        }

        /* Ensure the check-in and check-out dates are not already reserved */
        $requestedPeriod = new DatePeriod(
            new DateTime($checkIn),
            new DateInterval('P1D'),
            (new DateTime($checkOut))->modify('+1 day')
        );

        foreach ($requestedPeriod as $date) {
            if (in_array($date->format('Y-m-d'), $unavailableDates)) {
                http_response_code(400);
                $message = "The property is not available for the selected dates.";
                require 'views/reservations/create.php';
                return;
            }
        }

        /* Calculate the total price */
        $date_diff = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24); /* in days */
        $total_price = $date_diff * $property['price_per_night'];

        /* Create the reservation */
        $reservation_id = $model->createReservation([
            'user_id' => $_SESSION['user_id'],
            'property_id' => $property_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => $total_price,
            'status' => 'pending',
            'is_paid' => 0
        ]);

        if ($reservation_id) {
            http_response_code(200);
            header("Location: " . ROOT . "/payments/create/{$reservation_id}");
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'Failed to create reservation. Please try again later.';
            require 'views/errors/error.php';
            return;
        }
    }

    require 'views/reservations/create.php';
}

/* function for hosts to manage reservations for their properties */

function manage()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a host to manage reservations.';
        require 'views/errors/error.php';
        return;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Reservations();

    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    $reservations = $model->getReservationsByHost($user_id);

    http_response_code(200);
    require 'views/reservations/manage.php';
}

/* function to confirm a reservation */

function confirm($reservation_id)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a host to confirm reservations.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        $model = new Reservations();

        if ($model->updateReservationStatus($reservation_id, 'confirmed')) {
            $_SESSION['flash_message'] = "Reservation status updated to Confirmed successfully";
        } else {
            $_SESSION['flash_message'] = "Failed to confirm reservation";
        }

        header("Location: /reservations/manage");
        exit();
    }
}

function cancel($reservation_id)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a host to cancel reservations.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* validate csrf token */
        $submitted_csrf_token = $_POST['csrf_token'] ?? '';
        if (!validateCsrfToken($submitted_csrf_token)) {
            http_response_code(403);
            $errorCode = 403;
            $errorMessage = 'Invalid CSRF token. Please try again.';
            require 'views/errors/error.php';
            return;
        }

        $model = new Reservations();

        if ($model->updateReservationStatus($reservation_id, 'canceled')) {
            $_SESSION['flash_message'] = "Reservation status updated to Canceled successfully";
        } else {
            $_SESSION['flash_message'] = "Failed to cancel reservation";
        }

        header("Location: /reservations/manage");
        exit();
    }
}


/* functon to view reservation details */

function showDetails($reservation_id)
{

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to view reservation details.';
        require 'views/errors/error.php';
        return;
    }

    $model = new Reservations();
    $reservation = $model->getReservationById($reservation_id);

    if (!$reservation || $reservation['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'You are not authorized to view this reservation.';
        require 'views/errors/error.php';
        return;
    }

    /* Generate CSRF Token */
    $csrf_token = generateCsrfToken();

    /* check if paid */
    $isPaid = $reservation['is_paid'] ? 'Paid' : 'Not Paid';

    http_response_code(200);
    require 'views/reservations/showDetails.php';
    return;
}
