<?php

require_once 'models/Users.php';
require_once 'models/Properties.php';
require_once 'models/Reservations.php';
require_once 'models/Payments.php';

function index()
{
    $model = new Properties();
    $reservationModel = new Reservations();
    $paymentModel = new Payments();  // Assuming you have a Payments model for handling payment data

    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'host') {

        $properties = $model->getPropertiesByHost($_SESSION['user_id']);
        $reservations = $reservationModel->getReservationsByHost($_SESSION['user_id']);

        /* Get total earnings */
        $totalEarnings = $paymentModel->getTotalEarningsByHost($_SESSION['user_id']);

        /* Get recent activities */
        $recentActivities = $reservationModel->getRecentActivitiesByHost($_SESSION['user_id']);

        require_once 'views/dashboard/host.php';
    } elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {

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
    } else {

        /* fetch all properties for guests or non-logged-in users */
        $properties = $model->getAllWithImages(null);
        require_once 'views/home.php';
    }

    http_response_code(200);
}
