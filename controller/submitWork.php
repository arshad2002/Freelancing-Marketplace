<?php
session_start();
require_once("authCheck.php");
require_once("../model/applicationModel.php");

checkLoggedIn();
checkUserType("freelancer", "login.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $work_description = $_POST['work_description'];
    $freelancer_id = $_SESSION['user_id'];
    $work_file = null;
    
    // Verify that this application belongs to the logged-in freelancer
    $application = getApplicationDetails($application_id, $freelancer_id, 'freelancer');
    if (!$application || $application['status'] !== 'accepted') {
        echo "<script>
                alert('Invalid application or not authorized to submit work!');
                window.history.back();
              </script>";
        exit();
    }
    
    // Handle work file upload (optional)
    if (isset($_FILES['work_file']) && $_FILES['work_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../asset/work_submissions/';
        $fileInfo = pathinfo($_FILES['work_file']['name']);
        $fileExtension = strtolower($fileInfo['extension']);
        
        // Validate file type (allow common work file types)
        $allowedExtensions = ['pdf', 'doc', 'docx', 'zip', 'rar', 'txt', 'jpg', 'jpeg', 'png'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script>
                    alert('Invalid file type! Allowed: PDF, DOC, DOCX, ZIP, RAR, TXT, JPG, PNG');
                    window.history.back();
                  </script>";
            exit();
        }
        
        // Validate file size (10MB max)
        if ($_FILES['work_file']['size'] > 10 * 1024 * 1024) {
            echo "<script>
                    alert('File size must be less than 10MB!');
                    window.history.back();
                  </script>";
            exit();
        }
        
        // Generate unique filename
        $work_filename = "work_" . $freelancer_id . "_" . $application_id . "_" . time() . "." . $fileExtension;
        $uploadPath = $uploadDir . $work_filename;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['work_file']['tmp_name'], $uploadPath)) {
            $work_file = $work_filename;
        } else {
            echo "<script>
                    alert('Failed to upload work file!');
                    window.history.back();
                  </script>";
            exit();
        }
    }
    
    if (submitWork($application_id, $work_description, $work_file)) {
        echo "<script>
                alert('Work submitted successfully!');
                window.location.href = '../view/freelancerDashboard.php';
              </script>";
    } else {
        // Delete uploaded file if submission fails
        if ($work_file && file_exists($uploadDir . $work_file)) {
            unlink($uploadDir . $work_file);
        }
        echo "<script>
                alert('Failed to submit work!');
                window.history.back();
              </script>";
    }
} else {
    header("Location: ../view/freelancerDashboard.php");
    exit();
}
?>
