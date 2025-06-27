<?php
session_start();
require_once("../controller/authCheck.php");
require_once("../model/jobModel.php");

checkLoggedIn();
checkUserType("client", "login.php");

$job_id = $_GET['job_id'] ?? null;
$client_id = $_SESSION['user_id'];

if (!$job_id) {
    header("Location: clientDashboard.php");
    exit();
}

// Get job details
$job_data = searchJobsByJobID($job_id);
if (empty($job_data)) {
    echo "<script>
            alert('Job not found!');
            window.location.href = 'clientDashboard.php';
          </script>";
    exit();
}

$job = $job_data[0];

// Verify that this job belongs to the logged-in client
if ($job['client_id'] != $client_id) {
    echo "<script>
            alert('You are not authorized to edit this job!');
            window.location.href = 'clientDashboard.php';
          </script>";
    exit();
}

// Check if job has accepted applications - if so, restrict editing
require_once("../model/applicationModel.php");
$applications = fetchFreelancerApplications($job_id);
$hasAcceptedApplications = false;
foreach ($applications as $app) {
    if ($app['status'] === 'accepted' || $app['status'] === 'work_submitted' || $app['status'] === 'completed') {
        $hasAcceptedApplications = true;
        break;
    }
}

if ($hasAcceptedApplications) {
    echo "<script>
            alert('Cannot edit job: This job has accepted applications or work in progress!');
            window.location.href = 'jobView.php?job_id=" . $job_id . "';
          </script>";
    exit();
}

// Store job_id in session for the update controller
$_SESSION['jobid'] = $job_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <div>
            <table cellspacing="0" align="center">
                <tr height="10%">
                    <td>
                        <fieldset>
                            <legend><h2>Edit Job</h2></legend>
                            
                            <?php 
                            // Check for pending applications and show warning
                            $hasPendingApplications = false;
                            foreach ($applications as $app) {
                                if ($app['status'] === 'pending') {
                                    $hasPendingApplications = true;
                                    break;
                                }
                            }
                            
                            if ($hasPendingApplications): ?>
                                <div class="warning-card">
                                    <strong>⚠️ Warning:</strong> This job has pending applications. Editing may affect applicant expectations.
                                </div>
                            <?php endif; ?>
                            
                            <form action="../controller/clientJobUpdate.php" method="post" onsubmit="return jobPostValidition();">
                                <label>Job Title:</label><br>
                                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required><br><br>
                                
                                <label>Job Description:</label><br>
                                <textarea id="description" name="description" rows="4" cols="50" required><?php echo htmlspecialchars($job['description']); ?></textarea><br><br>
                            
                                <label>Job Type:</label><br>
                                <input type="radio" id="hourly" name="job_type" value="hourly" <?php echo ($job['job_type'] == 'hourly') ? 'checked' : ''; ?>>
                                <label for="hourly">Hourly</label><br>
                                <input type="radio" id="fixed" name="job_type" value="fixed" <?php echo ($job['job_type'] == 'fixed') ? 'checked' : ''; ?>>
                                <label for="fixed">Fixed</label><br><br>
                            
                                <label>Payment Amount:</label><br>
                                <input type="number" id="payment" name="payment" step="0.01" value="<?php echo $job['payment']; ?>" required><br><br>
                            
                                <input type="submit" value="Update Job" class="btn-success">
                                <input type="button" value="Cancel" onclick="window.location.href='jobView.php?job_id=<?php echo $job_id; ?>'" class="btn-danger">
                            </form>
                            <?php require("../controller/errorShowing.php"); ?>
                        </fieldset>
                    </td> 
                </tr>
            </table> 
        </div>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <script src="../asset/js/jobPostValidation.js"></script>
    <?php renderNavbarScript(); ?>
</body>
</html>
