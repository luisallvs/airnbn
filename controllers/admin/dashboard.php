<?php

require_once 'models/Users.php';
require_once 'models/Properties.php';
require_once 'models/Reservations.php';

function index()
{
    /* Check if the user is an admin */
    if ($_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $userModel = new Users();
    $propertyModel = new Properties();
    $reservationModel = new Reservations();

    $totalUsers = $userModel->countUsers();
    $totalProperties = $propertyModel->countProperties();
    $totalReservations = $reservationModel->countReservations();

    $lastFiveUsers = $userModel->getLastFiveUsers();

    $lastFiveProperties = $propertyModel->getLastFiveProperties();

    foreach ($lastFiveProperties as &$property) {
        $owner = $userModel->getById($property['user_id']);
        $property['owner_name'] = $owner['name'];
    }

    $recentReservations = $reservationModel->getRecentReservations();

    require 'views/admin/dashboard.php';
}
