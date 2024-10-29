<?php

function uploadPropertyImages($files, $property_id, $imageModel, $uploadDir, $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'], $maxFileSize = 5000000)
{
    /* Create upload directory if it doesn't exist */
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedImages = [];

    foreach ($files['tmp_name'] as $key => $tmp_name) {
        $originalName = $files['name'][$key];
        $fileSize = $files['size'][$key];
        $fileType = pathinfo($originalName, PATHINFO_EXTENSION);

        /* Check if the file is an image and its size is within the allowed limit */
        if (!empty($tmp_name) && in_array(strtolower($fileType), $allowedExtensions) && $fileSize <= $maxFileSize) {

            $imageData = file_get_contents($tmp_name);

            /* Generate a random file name */
            $fileName = bin2hex(random_bytes(16)) . '.' . $fileType;
            $filePath = $uploadDir . $fileName;

            /* Save the image file */
            if (file_put_contents($filePath, $imageData)) {
                /* Store the image URL in the database */
                $imageUrl = '/images/properties/' . $fileName;
                $imageModel->create([
                    'property_id' => $property_id,
                    'image_url' => $imageUrl
                ]);
                $uploadedImages[] = $imageUrl;
            }
        }
    }

    return $uploadedImages;
}

function uploadProfilePicture($profilePictureFile, $uploadDir = __DIR__ . '/../../images/pfp/', $allowedExtensions = ['jpg', 'jpeg', 'gif', 'webp'], $maxFileSize = 2000000)
{
    /* Create upload directory if it doesn't exist */
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    /* Get file extension and size */
    $fileType = pathinfo($profilePictureFile['name'], PATHINFO_EXTENSION);
    $fileSize = $profilePictureFile['size'];

    /* validate file type */
    if (!in_array(strtolower($fileType), $allowedExtensions)) {
        $message = "Invalid file type. Allowed types are: " . implode(', ', $allowedExtensions);
        return null;
    }

    /* validate file size */
    if ($fileSize > $maxFileSize) {
        $message = "File size exceeds the maximum limit of " . ($maxFileSize / 2000000) . " MB.";
        return null;
    }

    /* Generate a random file name */
    $fileName = bin2hex(random_bytes(16)) . '.' . $fileType;
    $filePath = $uploadDir . $fileName;

    /* Save the image file */
    if (move_uploaded_file($profilePictureFile['tmp_name'], $filePath)) {
        return "/images/pfp/" . $fileName;
    }

    return null;
}
