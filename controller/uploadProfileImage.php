<?php
session_start();
require_once("authCheck.php");
checkLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $userId = $_SESSION['user_id'];
        $uploadDir = '../asset/images/';
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $originalName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Validate file size (5MB max)
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($fileSize > $maxFileSize) {
            $_SESSION['error_message'] = 'File size must be less than 5MB.';
            header('Location: ../view/profile.php');
            exit();
        }
        
        // Validate file type
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $fileMimeType = mime_content_type($fileTmpPath);
        $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        
        if (!in_array($fileMimeType, $allowedMimeTypes) && !in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $_SESSION['error_message'] = 'Invalid file type. Please upload a valid image (JPEG, PNG, GIF, or WebP).';
            header('Location: ../view/profile.php');
            exit();
        }
        
        // Convert image to PNG and resize
        $fileName = $userId . '.png';
        $destPath = $uploadDir . $fileName;
        
        // Create image resource based on file type
        $imageResource = null;
        switch ($fileMimeType) {
            case 'image/jpeg':
                $imageResource = imagecreatefromjpeg($fileTmpPath);
                break;
            case 'image/png':
                $imageResource = imagecreatefrompng($fileTmpPath);
                break;
            case 'image/gif':
                $imageResource = imagecreatefromgif($fileTmpPath);
                break;
            case 'image/webp':
                $imageResource = imagecreatefromwebp($fileTmpPath);
                break;
        }
        
        if ($imageResource) {
            // Get original dimensions
            $originalWidth = imagesx($imageResource);
            $originalHeight = imagesy($imageResource);
            
            // Calculate new dimensions (max 400x400)
            $maxSize = 400;
            if ($originalWidth > $originalHeight) {
                $newWidth = $maxSize;
                $newHeight = ($originalHeight / $originalWidth) * $maxSize;
            } else {
                $newHeight = $maxSize;
                $newWidth = ($originalWidth / $originalHeight) * $maxSize;
            }
            
            // Create new image with calculated dimensions
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNG
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            
            // Resize image
            imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            
            // Save as PNG
            if (imagepng($newImage, $destPath)) {
                $_SESSION['success_message'] = 'Profile picture updated successfully!';
            } else {
                $_SESSION['error_message'] = 'Error saving the image file.';
            }
            
            // Clean up memory
            imagedestroy($imageResource);
            imagedestroy($newImage);
        } else {
            $_SESSION['error_message'] = 'Error processing the image file.';
        }
    } else {
        // Handle different upload errors
        switch ($_FILES['profile_image']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $_SESSION['error_message'] = 'File is too large.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $_SESSION['error_message'] = 'File upload was interrupted.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $_SESSION['error_message'] = 'No file was selected.';
                break;
            default:
                $_SESSION['error_message'] = 'Error uploading file. Please try again.';
        }
    }
    
    // Redirect back to the profile page
    header('Location: ../view/profile.php');
    exit();
} else {
    // Redirect back if not a POST request
    $_SESSION['error_message'] = 'Invalid request method.';
    header('Location: ../view/profile.php');
    exit();
}
?>
