<?php

require_once 'models/Properties.php';
require_once 'models/propertyImages.php';

function index()
{
    $model = new Properties();
    $properties = $model->getAllWithImages();

    http_response_code(200);
    require 'views/properties/index.php';
}

function manage()
{
    /* Make sure user is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'Unauthorized access.';
        require 'views/errors/error.php';
        return;
    }

    $user_id = $_SESSION['user_id'];
    $model = new Properties();

    /* Get properties for the host */
    $properties = $model->getPropertiesByHost($user_id);

    http_response_code(200);
    require 'views/properties/manage.php';
}


function manageSingle($property_id)
{
    $model = new Properties();
    $property = $model->getById($property_id);
    $imageModel = new PropertyImages();
    $images = $imageModel->getByPropertyId($property_id);

    if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = 'Unauthorized access.';
        require 'views/errors/error.php';
        return;
    }

    require 'views/properties/manageSingle.php';
}

function showDetails($property_id)
{
    $model = new Properties();
    $property = $model->getById($property_id);

    if (!$property) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Property not found.';
        require 'views/errors/error.php';
        return;
    }

    /* load property images */
    $imageModel = new PropertyImages();
    $images = $imageModel->getByPropertyId($property_id);

    http_response_code(200);
    require 'views/properties/showDetails.php';
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

        /* load model */
        $model = new Properties();
        $user_id = $_SESSION['user_id'];

        /* Sanitize user input */
        $data = [
            'user_id' => $user_id,
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

        /* Create property */
        $property_id = $model->create($data);

        /* handle images of the property */
        if ($property_id && isset($_FILES['property_images'])) {
            $imageModel = new PropertyImages();

            foreach ($_FILES['property_images']['tmp_name'] as $key => $tmp_name) {
                if (!empty($tmp_name)) {
                    $imageData = file_get_contents($tmp_name);
                    $fileName = bin2hex(random_bytes(16)) . '.jpg';
                    $imageDirectory = __DIR__ . '/../images';

                    if (!is_dir($imageDirectory)) {
                        mkdir($imageDirectory, 0777, true);
                    }

                    $filePath = $imageDirectory . '/' . $fileName;
                    file_put_contents($filePath, $imageData);

                    $imageUrl = '/images/' . $fileName;

                    $imageModel->create([
                        'property_id' => $property_id,
                        'image_url' => $imageUrl
                    ]);
                }
            }
        }

        /* Redirect to properties list */
        header('Location: /properties');
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
            header('Location: /properties/manageSingle/' . $property_id);
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
        $errorCode = 401;
        $errorMessage = "You are not authorized to perform this action.";
        require 'views/errors/error.php';
        return;
    }

    $model = new Properties();
    $property = $model->getById($property_id);

    /* Check if the property belongs to the logged-in user */
    if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = "You do not have permission to delete this property.";
        require 'views/errors/error.php';
        return;
    }

    if ($model->delete($property_id, $_SESSION['user_id'])) {
        http_response_code(200);
        header('Location: /home');
        exit;
    } else {
        http_response_code(500);
        $errorCode = 500;
        $errorMessage = "Something went wrong on our end. Please try again later.";
        require 'views/errors/error.php';
        return;
    }
}
