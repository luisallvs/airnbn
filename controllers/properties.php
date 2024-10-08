<?php

/* Start session if not  started */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/Properties.php';

function create()
{

    /* MAke sureuser is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* Sanitize user input */
        $data = [
            'user_id' => $_SESSION['user_id'],
            'name' => htmlspecialchars($_POST['name']),
            'description' => htmlspecialchars($_POST['description']),
            'address' => htmlspecialchars($_POST['address']),
            'city' => htmlspecialchars($_POST['city']),
            'country' => htmlspecialchars($_POST['country']),
            'price_per_night' => $_POST['price_per_night'],
            'max_guests' => $_POST['max_guests'],
            'availability_start' => $_POST['availability_start'],
            'availability_end' => $_POST['availability_end']
        ];

        $model = new Properties();

        $model->create($data);

        /* Redirect to properties list */
        header('Location: /home');
        exit;
    }

    require 'views/properties/create.php';
}

function index()
{
    $model = new Properties();
    $properties = $model->getByUserId($_SESSION['user_id']);
    require 'views/properties/index.php';
}

function update($property_id)
{
    $model = new Properties();
    $property = $model->getById($property_id);

    /* Check if the property belongs to the logged-in user */
    if ($property['user_id'] !== $_SESSION['user_id']) {
        die("Access denied.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /* Sanitize user input */
        $data = [
            'property_id' => $property_id,
            'user_id' => $_SESSION['user_id'],
            'name' => htmlspecialchars($_POST['name']),
            'description' => htmlspecialchars($_POST['description']),
            'address' => htmlspecialchars($_POST['address']),
            'city' => htmlspecialchars($_POST['city']),
            'country' => htmlspecialchars($_POST['country']),
            'price_per_night' => $_POST['price_per_night'],
            'max_guests' => $_POST['max_guests'],
            'availability_start' => $_POST['availability_start'],
            'availability_end' => $_POST['availability_end']
        ];

        $model->update($data);

        /* Redirect to properties list */
        header('Location: /properties');
        exit;
    }

    require 'views/properties/update.php';
}

function delete($property_id)
{
    $model = new Properties();
    $model->delete($property_id, $_SESSION['user_id']);
    header('Location: /properties');
    exit;
}
