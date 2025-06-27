<?php
require_once("db.php");

function fetchFreelancerApplications($jobId) {
    $conn = getConnection();

    $query = "SELECT applications.application_id, applications.job_id, applications.freelancer_id, 
              applications.application_text, applications.cv_file, applications.work_file, 
              applications.work_description, applications.work_submitted_date, 
              applications.application_date, applications.status,
              users.username, users.email
              FROM applications
              JOIN users ON applications.freelancer_id = users.user_id
              WHERE applications.job_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();

    $applications = [];

    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $applications;
}

function updateApplicationStatus($applicationId, $status) {
    try {
        $conn = getConnection();
        $validStatusValues = ["accepted", "rejected", "pending", "work_submitted", "completed"]; 
        if (!in_array($status, $validStatusValues)) {
            throw new Exception("Invalid status value.");
        }

        $query = "UPDATE applications SET status = ? WHERE application_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $applicationId);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function checkReApply($jobId, $freelancerId) {
    $conn = getConnection();
    $query = "SELECT * FROM applications WHERE job_id = ? AND freelancer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $jobId, $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function applyJob($jobId, $freelancerId, $applicationText, $cv_file = null) {
    
    try{
        $conn = getConnection();

        $insertQuery = "INSERT INTO applications (job_id, freelancer_id, application_text, cv_file, status) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);

        $status = "pending";
        $insertStmt->bind_param("sssss", $jobId, $freelancerId, $applicationText, $cv_file, $status);
        $insertStmt->execute();
        return true;
    }
    catch(Exception $e){
        return false;
    }
}


function fetchStatus($jobId, $freelancerId) {
    $conn = getConnection();
    $query = "SELECT status FROM applications WHERE job_id = ? AND freelancer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $jobId, $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['status']; // Return the status string if found
    }
    
    return "Not Applied Yet!"; // Return null if no matching row is found
}

function submitWork($applicationId, $workDescription, $workFile = null) {
    try {
        $conn = getConnection();
        
        $query = "UPDATE applications SET work_description = ?, work_file = ?, work_submitted_date = NOW(), status = 'work_submitted' WHERE application_id = ? AND status = 'accepted'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $workDescription, $workFile, $applicationId);
        $stmt->execute();
        
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        $conn->close();
        
        return $affectedRows > 0;
    } catch (Exception $e) {
        return false;
    }
}

function getFreelancerAcceptedApplications($freelancerId) {
    $conn = getConnection();
    
    $query = "SELECT a.application_id, a.job_id, a.status, a.work_description, a.work_file, a.work_submitted_date,
              j.title, j.description, j.payment, j.job_type
              FROM applications a
              JOIN jobs j ON a.job_id = j.job_id
              WHERE a.freelancer_id = ? AND a.status IN ('accepted', 'work_submitted', 'completed')
              ORDER BY a.application_date DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $freelancerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $applications = [];
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $applications;
}

function getApplicationDetails($applicationId, $userId, $userType) {
    $conn = getConnection();
    
    if ($userType === 'freelancer') {
        $query = "SELECT a.*, j.title, j.description, j.payment, j.job_type
                  FROM applications a
                  JOIN jobs j ON a.job_id = j.job_id
                  WHERE a.application_id = ? AND a.freelancer_id = ?";
    } else if ($userType === 'client') {
        $query = "SELECT a.*, j.title, j.description, j.payment, j.job_type, u.username, u.email
                  FROM applications a
                  JOIN jobs j ON a.job_id = j.job_id
                  JOIN users u ON a.freelancer_id = u.user_id
                  WHERE a.application_id = ? AND j.client_id = ?";
    } else {
        return null;
    }
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $applicationId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $application = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $application;
}

?>