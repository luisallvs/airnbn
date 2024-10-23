<?php

require_once 'models/properties.php';
require_once 'models/propertyImages.php';
require_once 'models/reviews.php';
require_once 'controllers/file_utils.php';

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
        $errorMessage = 'You have to be logged in as a host to manage properties.';
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
        $errorMessage = 'You do not have permission to view this property.';
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

    /* load reviews */
    $reviewModel = new Reviews();
    $reviews = $reviewModel->getReviewsByProperty($property_id);

    http_response_code(200);
    require 'views/properties/showDetails.php';
}

function create()
{

    /* Make sure user is logged in and is a host */
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'host') {
        http_response_code(401);
        $errorCode = 401;
        $errorMessage = 'You have to be logged in as a host to create properties.';
        require 'views/errors/error.php';
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* load model */
        $model = new Properties();
        $imageModel = new PropertyImages();
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
            $uploadDir = __DIR__ . '/../images/properties/';
            uploadPropertyImages(
                $_FILES['property_images'], /* the files array */
                $property_id,                /* The property ID */
                $imageModel,                  /* The image model */
                $uploadDir                    /* The upload directory */
            );
        }

        /* Redirect to properties list */
        header('Location: /properties');
        return;
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
        $errorCode = 403;
        $errorMessage = 'You do not have permission to update this property.';
        require 'views/errors/error.php';
        return;
    }

    /* fetch existing images */
    $imageModel = new PropertyImages();
    $images = $imageModel->getByPropertyId($property_id);

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

            /* handle deletion of images */
            if (!empty($_POST['delete_images'])) {
                foreach ($_POST['delete_images'] as $imageId) {
                    $image = $imageModel->getById($imageId);
                    if ($image) {
                        /* Delete the image */
                        unlink(__DIR__ . '/../' . $image['image_url']);

                        /* Delete the image record from the database */
                        $imageModel->delete($imageId);
                    }
                }
            }

            if (!empty($_FILES['property_images']['name'][0])) {
                $uploadDir = __DIR__ . '/../images/properties/';
                uploadPropertyImages(
                    $_FILES['property_images'], /* the files array */
                    $property_id,                /* The property ID */
                    $imageModel,                  /* The image model */
                    $uploadDir                    /* The upload directory */
                );
            }

            http_response_code(200);
            header('Location: /properties/manageSingle/' . $property_id);
            return;
        } else {
            http_response_code(500);
            $errorCode = 500;
            $errorMessage = 'Failed to update property.';
            require 'views/errors/error.php';
            return;
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
        $errorMessage = "You have to be logged in as a host to delete properties.";
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

    if ($model->hasActiveOrFuturePayments($property_id)) {
        http_response_code(403);
        $errorCode = 403;
        $errorMessage = "You cannot delete this property because it has payments associated with it.";
        require 'views/errors/error.php';
        return;
    }

    if ($model->delete($property_id, $_SESSION['user_id'])) {
        http_response_code(200);
        header('Location: /properties/manage');
        return;
    } else {
        http_response_code(500);
        $errorCode = 500;
        $errorMessage = "Something went wrong on our end. Please try again later.";
        require 'views/errors/error.php';
        return;
    }
}
