<?php

require_once 'models/Properties.php';
require_once 'models/Reservations.php';
require_once 'models/Payments.php';

function hostDashboard()
{
    // Ensure the user is logged in and is a host
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Fetch data related to the host
    $propertiesModel = new Properties();
    $reservationsModel = new Reservations();
    $paymentsModel = new Payments();

    // Fetch the properties owned by the host
    $properties = $propertiesModel->getPropertiesByHost($user_id);

    // Fetch the reservations for the host's properties
    $reservations = $reservationsModel->getReservationsByHost($user_id);

    // Fetch the total earnings
    $totalEarnings = $paymentsModel->getTotalEarningsByHost($user_id);

    // Fetch recent activities (e.g., new bookings, cancellations)
    $recentActivities = $reservationsModel->getRecentActivitiesByHost($user_id);

    // Pass the data to the view
    require 'views/dashboard/host_dashboard.php';
}
