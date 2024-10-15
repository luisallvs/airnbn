<?php

require_once 'models/Payments.php';
require_once 'models/PaymentMethods.php';
require_once 'models/Reservations.php';

function create($reservation_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
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

    require 'views/payments/create.php';
}

function submit($reservation_id)
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $reservationModel = new Reservations();
    $reservation = $reservationModel->getReservationById($reservation_id);

    if (!$reservation) {
        http_response_code(404);
        exit('Reservation not found.');
    }

    if ($reservation['is_paid'] == 1) {
        http_response_code(400);
        exit('This reservation has already been paid for.');
    }

    if (empty($_POST['method_id'])) {
        http_response_code(400);
        exit('Please select a payment method.');
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
        exit;
    } else {
        http_response_code(500);
        $message = "Failed to process the payment.";
        require 'views/payments/create.php';
    }
}
