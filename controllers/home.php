<?php

require_once 'models/Properties.php';

function index()
{
    $model = new Properties();

    /* If the user is logged in and is a host, fetch only the host's properties */
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'host') {
        $properties = $model->getPropertiesByHost($_SESSION['user_id']);
    } else {
        /* Fetch all properties for guests or non-logged-in users */
        $properties = $model->getAllWithImages(null);
    }

    http_response_code(200);
    require_once 'views/home.php';
}
