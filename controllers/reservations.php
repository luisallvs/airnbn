<?php

require_once "models/reservations.php";
require_once "models/properties.php";
require_once "models/payments.php";
require_once "models/paymentMethods.php";

/* function to create a new reservation */

function create($property_id)
{
    /* Make sure user is logged in */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'guest') {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Reservations();
    $propertyModel = new Properties();
    $property = $propertyModel->getById($property_id);

    if (!$property) {
        http_response_code(404);
        exit("Property not found");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $checkIn = $_POST['check_in'] ?? "";
        $checkOut = $_POST['check_out'] ?? "";

        /* validate dates */
        if (empty($checkIn) || empty($checkOut) || strtotime($checkIn) >= strtotime($checkOut)) {
            http_response_code(400);
            $message = "Invalid dates. Please ensure the check-out date is after the check-in date.";
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
            // No echo or output before this header.
            header("Location: " . ROOT . "/payments/create/{$reservation_id}");
            exit;
        } else {
            http_response_code(500);
            $message = "Failed to create the reservation.";
        }
    }

    require 'views/reservations/create.php';
}

/* fucntion to list users reservations */

function index()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Reservations();

    $user_id = $_SESSION['user_id'];
    $reservations = $model->getReservationsByUser($user_id);

    http_response_code(200);
    require 'views/reservations/index.php';
}

/* function for hosts to manage reservations for their properties */

function manage()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        header('Location: /login');
        exit;
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
        header('Location: /login');
        exit;
    }

    $model = new Reservations();

    // Ensure this actually returns a true/false response from the model
    if ($model->updateReservationStatus($reservation_id, 'confirmed')) {
        $message = "Reservation confirmed successfully";
        http_response_code(200);
    } else {
        $message = "Failed to confirm reservation";
        http_response_code(500);
    }

    header("Location: /reservations/manage");
    exit;
}

/* fucntion to cancel a reservation */

function cancel($reservation_id)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Reservations();

    // Ensure this actually returns a true/false response from the model
    if ($model->updateReservationStatus($reservation_id, 'canceled')) {
        $message = "Reservation cancelled successfully";
        http_response_code(200);
    } else {
        $message = "Failed to cancel reservation";
        http_response_code(500);
    }

    header("Location: /reservations/manage");
    exit;
}

/* functon to view reservation details */

function showDetails($reservation_id)
{

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Reservations();
    $reservation = $model->getReservationById($reservation_id);

    if (!$reservation || $reservation['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        exit("You are not authorized to view this reservation.");
    }

    /* check if paid */
    $isPaid = $reservation['is_paid'] ? 'Paid' : 'Not Paid';

    http_response_code(200);
    require 'views/reservations/showDetails.php';
}
