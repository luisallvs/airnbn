<?php

require_once 'models/Payments.php';
require_once 'models/PaymentMethods.php';
require_once 'models/Reservations.php';

require_once 'controllers/utils/csrf_utils.php';

function create($reservation_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to make a reservation.';
        require 'views/errors/error.php';
        return;
    }

    $reservationModel = new Reservations();
    $reservation = $reservationModel->getReservationById($reservation_id);

    if (!$reservation) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Reservation not found.';
        require 'views/errors/error.php';
        return;
    }

    if ($reservation['is_paid'] == 1) {
        http_response_code(400);
        $errorCode = 400;
        $errorMessage = 'This reservation has already been paid for.';
        require 'views/errors/error.php';
        return;
    }

    if ($reservation["user_id"] !== $_SESSION['user_id']) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'You are not authorized to pay for this reservation.';
        require 'views/errors/error.php';
        return;
    }

    $PaymentMethodModel = new PaymentMethods();
    $paymentMethods = $PaymentMethodModel->getAllPaymentMethods();

    /* generate csrf token */
    $csrf_token = generateCsrfToken();

    require 'views/payments/create.php';
}

function submit($reservation_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in.';
        require 'views/errors/error.php';
        return;
    }

    /* validate csrf token */
    $submitted_csrf_token = $_POST['csrf_token'] ?? '';

    if (!validateCsrfToken($submitted_csrf_token)) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'Invalid CSRF token. Please try again.';
        require 'views/errors/error.php';
        return;
    }

    $reservationModel = new Reservations();
    $reservation = $reservationModel->getReservationById($reservation_id);

    if (!$reservation) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Reservation not found.';
        require 'views/errors/error.php';
        return;
    }

    if ($reservation['is_paid'] == 1) {
        http_response_code(400);
        $errorCode = 400;
        $errorMessage = 'This reservation has already been paid for.';
        require 'views/errors/error.php';
        return;
    }

    if (empty($_POST['method_id'])) {
        http_response_code(400);
        $errorCode = 400;
        $errorMessage = 'Please select a payment method.';
        require 'views/payments/create.php';
        return;
    }

    $paymentModel = new Payments();
    $payment_id = $paymentModel->createPayment([
        'reservation_id' => $reservation_id,
        'method_id' => $_POST['method_id'],
        'amount' => $reservation['total_price'],
        'status' => 'completed'
    ]);

    if ($payment_id) {
        /* mark reservation as paid */
        $reservationModel->markAsPaid($reservation_id);
        header("Location: " . ROOT . "/reservations/showDetails/" . $reservation_id);
    } else {
        http_response_code(500);
        $errorCode = 500;
        $message = "Failed to process the payment.";
        require 'views/errors/error.php';
    }
}
