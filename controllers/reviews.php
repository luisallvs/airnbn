<?php

require_once 'models/reviews.php';
require_once 'models/reservations.php';
require_once 'models/properties.php';

require_once 'controllers/utils/csrf_utils.php';

function create($reservation_id)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'guest') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in to write a review.';
        require 'views/errors/error.php';
        return;
    }

    $reservationModel = new Reservations();
    $reservation = $reservationModel->getReservationById($reservation_id);

    /* check if reservation exists */
    if (!$reservation) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Reservation not found.';
        require 'views/errors/error.php';
        return;
    }

    /* check if reservation belongs to the logged in user */
    if ($reservation['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'You are not authorized to write a review for this reservation.';
        require 'views/errors/error.php';
        return;
    }

    /* check if reservation is completed */
    if (strtotime($reservation['check_out']) > time()) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'You can only review after the reservation is completed.';
        require 'views/errors/error.php';
        return;
    }

    /* check if user has already reviewed */
    $reviewModel = new Reviews();

    if ($reviewModel->reviewExistsForReservation($reservation_id)) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'You have already reviewed this reservation.';
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

        $data = [
            'user_id' => $_SESSION['user_id'],
            'property_id' => $reservation['property_id'],
            'reservation_id' => $reservation_id,
            'rating' => $_POST['rating'],
            'comment' => htmlspecialchars($_POST['comment'])
        ];

        if ($reviewModel->addReview($data)) {
            header('Location: /properties/showDetails/' . $reservation['property_id']);
            return;
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'Failed to add review.';
            require 'views/errors/error.php';
            return;
        }
    } else {
        /* generate csrf token */
        $csrf_token = generateCsrfToken();

        $propertyModel = new Properties();
        $property = $propertyModel->getById($reservation['property_id']);

        if (!$property) {
            http_response_code(404);
            $errorCode = 404;
            $errorMessage = 'Property not found.';
            require 'views/errors/error.php';
            return;
        }

        require 'views/reviews/create.php';
    }
}

function getReviewsByProperty($property_id)
{
    $reviewModel = new Reviews();
    return $reviewModel->getReviewsByProperty($property_id);
}
