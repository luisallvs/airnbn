<?php

require_once 'models/Users.php';
require_once 'models/Properties.php';
require_once 'models/Reservations.php';

function index()
{
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $reservationModel = new Reservations();
    $allReservations = $reservationModel->getAll();
    require 'views/admin/reservations.php';
}

function create()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservationData = [
            'user_id' => $_POST['user_id'],
            'property_id' => $_POST['property_id'],
            'check_in' => $_POST['check_in'],
            'check_out' => $_POST['check_out'],
            'total_price' => $_POST['total_price'],
            'status' => $_POST['status'],
            'is_paid' => $_POST['is_paid']
        ];

        $model = new Reservations();
        if ($model->createReservation($reservationData)) {
            header("Location: /admin/reservations");
            exit();
        } else {
            $errorMessage = "Error creating reservation.";
            require 'views/errors/error.php';
        }
    } else {
        $userModel = new Users();
        $propertyModel = new Properties();

        $users = $userModel->getAll();
        $properties = $propertyModel->getAll();

        require 'views/admin/createReservation.php';
    }
}


function edit($reservation_id)
{

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatedData = [
            'check_in' => htmlspecialchars($_POST['check_in']),
            'check_out' => htmlspecialchars($_POST['check_out']),
        ];

        if ($reservationModel->updateReservation($reservation_id, $updatedData)) {
            http_response_code(200);
            header('Location: /admin/reservations');
            exit();
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'Failed to update reservation.';
            require 'views/errors/error.php';
            return;
        }
    }

    http_response_code(200);
    require 'views/admin/editReservation.php';
}

function delete($reservation_id)
{

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
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

    if ($reservationModel->delete($reservation_id)) {
        http_response_code(200);
        header('Location: /admin/reservations');
        exit();
    } else {
        http_response_code(500);
        $errorCode = 500;
        $errorMessage = 'Failed to delete reservation.';
        require 'views/errors/error.php';
        return;
    }
}

function updateStatus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservation_id = $_POST['reservation_id'];
        $newStatus = $_POST['status'];

        if ($reservation_id && in_array($newStatus, ['confirmed', 'pending', 'canceled'])) {
            $model = new Reservations();
            $reservation = $model->getReservationById($reservation_id);

            if ($reservation) {
                if ($model->updateReservationStatus($reservation_id, $newStatus)) {
                    http_response_code(200);
                    echo 'Success';
                } else {
                    http_response_code(500);
                    echo 'Error updating reservation status';
                }
            } else {
                http_response_code(404);
                echo 'Reservation not found';
            }
        } else {
            http_response_code(400);
            echo 'Invalid input';
        }
    }
}

function updateIsPaid()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservationId = $_POST['reservation_id'];
        $isPaid = $_POST['is_paid'];

        $reservationModel = new Reservations();
        if ($reservationModel->updateIsPaid($reservationId, $isPaid)) {
            http_response_code(200);
            echo "Success";
        } else {
            http_response_code(500);
            echo "Error updating is_paid status";
        }
    }
}
