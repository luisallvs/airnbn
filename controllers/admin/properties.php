<?php

require_once 'models/Properties.php';
require_once 'models/PropertyImages.php';
require_once 'models/Users.php';
require_once 'controllers/file_utils.php';

function index()
{
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $propertyModel = new Properties();
    $allProperties = $propertyModel->getAll();
    require 'views/admin/properties.php';
}

function create()
{
    if (!isset($_SESSION['admin']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You need to be logged in as an admin to create properties.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new Properties();
        $imageModel = new PropertyImages();
        $userModel = new Users();

        /* Check if the host ID exists and if the user is a host */
        $owner_id = $_POST['owner_id'];
        $owner = $userModel->getById($owner_id);

        if (!$owner || $owner['role'] !== 'host') {
            http_response_code(400);
            $errorCode = 400;
            $errorMessage = "The specified owner ID does not exist or the user is not a host.";
            require 'views/errors/error.php';
            return;
        }

        /* Sanitize user input */
        $data = [
            'user_id' => $_POST['owner_id'],
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

        $property_id = $model->create($data);

        /* Upload property images */
        if ($property_id && isset($_FILES['property_images'])) {
            $uploadDir = __DIR__ . '/../../images/properties/';
            uploadPropertyImages(
                $_FILES['property_images'], // The files array
                $property_id, // The property ID
                $imageModel,  // The image model
                $uploadDir    // The upload directory
            );
        }

        http_response_code(201);
        header('Location: /admin/properties');
        return;
    }

    http_response_code(200);
    require 'views/admin/createProperty.php';
}


function edit($property_id)
{

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $propertyModel = new Properties();
    $imageModel = new PropertyImages();

    $property = $propertyModel->getById($property_id);
    $images = $imageModel->getByPropertyId($property_id);

    if (!$property) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = 'Property not found.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'property_id' => $property_id,
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

        if ($propertyModel->update($data)) {
            if (!empty($_POST['delete_images'])) {
                foreach ($_POST['delete_images'] as $imageId) {
                    $image = $imageModel->getById($imageId);
                    if ($image) {
                        unlink(__DIR__ . '/../' . $image['image_url']);
                        $imageModel->delete($imageId);
                    }
                }
            }

            if (!empty($_FILES['property_images']['name'][0])) {
                $uploadDir = __DIR__ . '/../../images/properties/';
                uploadPropertyImages(
                    $_FILES['property_images'], // The files array
                    $property_id, // The property ID
                    $imageModel,  // The image model
                    $uploadDir    // The upload directory
                );
            }

            http_response_code(200);
            header('Location: /admin/properties');
            exit();
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'Failed to update property.';
            require 'views/errors/error.php';
            return;
        }
    }

    http_response_code(200);
    require 'views/admin/editProperty.php';
}

function delete($property_id)
{
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(302);
        $errorCode = 302;
        $errorMessage = 'You are not authorized to access this page.';
        require 'views/errors/error.php';
        exit();
    }

    $propertyModel = new Properties();
    $property = $propertyModel->getById($property_id);

    if (!$property) {
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = "Property not found.";
        require 'views/errors/error.php';
        return;
    }

    if ($propertyModel->hasActiveOrFuturePayments($property_id)) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = "You cannot delete this property because it has payments associated with it.";
        require 'views/errors/error.php';
        return;
    }

    $imageModel = new PropertyImages();
    $images = $imageModel->getByPropertyId($property_id);
    foreach ($images as $image) {
        $imagePath = __DIR__ . '/../' . $image['image_url'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imageModel->delete($image['images_id']);
    }

    if ($propertyModel->delete($property_id)) {
        http_response_code(200);
        header('Location: /admin/properties');
        return;
    } else {
        http_response_code(500);
        $errorCode = 500;
        $errorMessage = "Something went wrong on our end. Please try again later.";
        require 'views/errors/error.php';
        return;
    }
}
