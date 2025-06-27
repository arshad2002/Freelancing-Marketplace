<?php
session_start();
require_once("authCheck.php");
require_once("../model/applicationModel.php");

checkLoggedIn();
checkUserType("client", "login.php");

if (isset($_GET['cv_file']) && isset($_GET['application_id'])) {
    $cv_file = $_GET['cv_file'];
    $application_id = $_GET['application_id'];
    $client_id = $_SESSION['user_id'];
    
    // Verify that this client owns the job for this application
    if (verifyClientAccessToCV($application_id, $client_id)) {
        $file_path = '../asset/cv/' . $cv_file;
        
        if (file_exists($file_path)) {
            // Set headers for file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($cv_file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            
            // Clear output buffer
            ob_clean();
            flush();
            
            // Read and output the file
            readfile($file_path);
            exit;
        } else {
            echo "<script>
                    alert('CV file not found!');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Access denied!');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request!');
            window.history.back();
          </script>";
}

function verifyClientAccessToCV($application_id, $client_id) {
    $conn = getConnection();
    
    $query = "SELECT j.client_id 
              FROM applications a 
              JOIN jobs j ON a.job_id = j.job_id 
              WHERE a.application_id = ? AND j.client_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $application_id, $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $hasAccess = $result->num_rows > 0;
    
    $stmt->close();
    $conn->close();
    
    return $hasAccess;
}
?>
