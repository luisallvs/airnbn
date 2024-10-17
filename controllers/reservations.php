<?php

require_once "models/reservations.php";
require_once "models/properties.php";
require_once "models/payments.php";
require_once "models/paymentMethods.php";

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

    foreach ($reservations as &$reservation) {
        $reservation["payment_status"] = $reservation["is_paid"] ? "Paid" : "Not Paid";
    }

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
        $errorMessage = 'You have to be logged in to make a reservation.';
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
        $checkIn = $_POST['check_in'] ?? "";
        $checkOut = $_POST['check_out'] ?? "";

        /* get today's date */
        $today = date('Y-m-d');

        /* validate dates */
        if (empty($checkIn) || empty($checkOut) || strtotime($checkIn) >= strtotime($checkOut)) {
            http_response_code(400);
            $message = "Invalid dates. Please ensure the check-out date is after the check-in date.";
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

        if (!$model->isAvailable($property_id, $checkIn, $checkOut)) {
            http_response_code(400);
            $message = "The property is not available for the selected dates.";
            require 'views/reservations/create.php';
            return;
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

    $model = new Reservations();

    // Ensure this actually returns a true/false response from the model
    if ($model->updateReservationStatus($reservation_id, 'confirmed')) {
        $message = "Reservation confirmed successfully";
        http_response_code(200);
    } else {
        http_response_code(500);
        $message = "Failed to confirm reservation";
    }

    header("Location: /reservations/manage");
}

/* fucntion to cancel a reservation */

function cancel($reservation_id)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a host to cancel reservations.';
        require 'views/errors/error.php';
        return;
    }

    $model = new Reservations();

    if ($model->updateReservationStatus($reservation_id, 'canceled')) {
        $message = "Reservation cancelled successfully";
        http_response_code(200);
    } else {
        $message = "Failed to cancel reservation";
        http_response_code(500);
    }

    header("Location: /reservations/manage");
    return;
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

    /* check if paid */
    $isPaid = $reservation['is_paid'] ? 'Paid' : 'Not Paid';

    http_response_code(200);
    require 'views/reservations/showDetails.php';
    return;
}
