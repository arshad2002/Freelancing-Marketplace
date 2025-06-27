<?php
session_start();
require_once("../model/jobModel.php");
require_once("../model/applicationModel.php");
require_once("authCheck.php");

checkLoggedIn();
checkUserType("client", "login.php");

$jobId = $_SESSION['jobid'];
$client_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify job ownership
    $jobDetails = searchJobsByJobID($jobId);
    if (empty($jobDetails) || $jobDetails[0]['client_id'] != $client_id) {
        echo "<script>
                alert('Unauthorized: You cannot edit this job!');
                window.location.href = '../view/clientDashboard.php';
              </script>";
        exit();
    }
    
    // Check if job has accepted applications
    $applications = fetchFreelancerApplications($jobId);
    foreach ($applications as $app) {
        if ($app['status'] === 'accepted' || $app['status'] === 'work_submitted' || $app['status'] === 'completed') {
            echo "<script>
                    alert('Cannot update: This job has accepted applications or work in progress!');
                    window.location.href = '../view/jobView.php?job_id=$jobId';
                  </script>";
            exit();
        }
    }
    
    $job_title = $_POST['title'];
    $job_description = $_POST['description'];
    $job_type = $_POST['job_type'];
    $payment = $_POST['payment'];
    
    // Validate input
    if (empty($job_title) || empty($job_description) || empty($job_type) || empty($payment)) {
        echo "<script>
                alert('All fields are required!');
                window.history.back();
              </script>";
        exit();
    }
    
    if ($payment <= 0) {
        echo "<script>
                alert('Payment amount must be greater than 0!');
                window.history.back();
              </script>";
        exit();
    }
    
    // Update the job
    $updateResult = updateJob($jobId, $job_title, $job_description, $job_type, $payment);
    
    if ($updateResult['success']) {
        echo "<script>
                alert('Job updated successfully!');
                window.location.href = '../view/jobView.php?job_id=$jobId';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update job: " . addslashes($updateResult['message']) . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: ../view/clientDashboard.php");
    exit();
}
?>