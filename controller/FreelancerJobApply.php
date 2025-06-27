<?php
session_start();
require_once("../model/applicationModel.php");
$jobId = $_SESSION['jobid'];
$freelancerId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_text = $_POST['description'];
    $cv_file = null;
    
    // Handle CV file upload
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../asset/cv/';
        $fileInfo = pathinfo($_FILES['cv_file']['name']);
        $fileExtension = strtolower($fileInfo['extension']);
        
        // Validate file type
        if ($fileExtension !== 'pdf') {
            echo "<script>
                    alert('Only PDF files are allowed!');
                    window.history.back();
                  </script>";
            exit();
        }
        
        // Validate file size (5MB max)
        if ($_FILES['cv_file']['size'] > 5 * 1024 * 1024) {
            echo "<script>
                    alert('File size must be less than 5MB!');
                    window.history.back();
                  </script>";
            exit();
        }
        
        // Generate unique filename using freelancer_id and job_id
        $cv_filename = "cv_" . $freelancerId . "_" . $jobId . "_" . time() . ".pdf";
        $uploadPath = $uploadDir . $cv_filename;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadPath)) {
            $cv_file = $cv_filename;
        } else {
            echo "<script>
                    alert('Failed to upload CV file!');
                    window.history.back();
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('CV file is required!');
                window.history.back();
              </script>";
        exit();
    }
    
    if(!applyJob($jobId, $freelancerId, $application_text, $cv_file)){
        // Delete uploaded file if job application fails
        if ($cv_file && file_exists($uploadDir . $cv_file)) {
            unlink($uploadDir . $cv_file);
        }
        echo "<script>
                alert('Job Unavailable');
                window.location.href = '../view/freelancerDashboard.php';
              </script>";
        exit();
    }
    header("Location: ../view/JobApply.php?job_id=$jobId");
    exit();
}
?>