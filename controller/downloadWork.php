<?php
session_start();
require_once("authCheck.php");
require_once("../model/applicationModel.php");

checkLoggedIn();
checkUserType("client", "login.php");

if (isset($_GET['work_file']) && isset($_GET['application_id'])) {
    $work_file = $_GET['work_file'];
    $application_id = $_GET['application_id'];
    $client_id = $_SESSION['user_id'];
    
    // Verify that this client owns the job for this application
    if (verifyClientAccessToWork($application_id, $client_id)) {
        $file_path = '../asset/work_submissions/' . $work_file;
        
        if (file_exists($file_path)) {
            // Get file extension to set appropriate content type
            $file_ext = strtolower(pathinfo($work_file, PATHINFO_EXTENSION));
            $content_types = [
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                'txt' => 'text/plain',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png'
            ];
            
            $content_type = $content_types[$file_ext] ?? 'application/octet-stream';
            
            // Set headers for file download
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . basename($work_file) . '"');
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
                    alert('Work file not found!');
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

function verifyClientAccessToWork($application_id, $client_id) {
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
