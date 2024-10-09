<?php

require_once 'models/Properties.php';

function index()
{

    /* Make sure user is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Properties();
    $properties = $model->getByUserId($_SESSION['user_id']);

    http_response_code(200);
    require 'views/properties/index.php';
}

function create()
{

    /* Make sure user is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
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

    http_response_code(200);
    require 'views/properties/create.php';
}

function update($property_id)
{
    $model = new Properties();
    $property = $model->getById($property_id);

    /* Check if the property belongs to the logged-in user */
    if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        exit;
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

        if ($model->update($data)) {
            http_response_code(200);
            header('Location: /properties');
            exit;
        } else {
            http_response_code(500);
            exit;
        }
    }

    http_response_code(200);
    require 'views/properties/update.php';
}

function delete($property_id)
{
    /* Make sure user is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        header('Location: /login');
        exit;
    }

    $model = new Properties();
    $property = $model->getById($property_id);

    /* Check if the property belongs to the logged-in user */
    if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        exit;
    }

    if ($model->delete($property_id, $_SESSION['user_id'])) {
        http_response_code(200);
        header('Location: /home');
        exit;
    } else {
        http_response_code(500);
        exit;
    }
}
