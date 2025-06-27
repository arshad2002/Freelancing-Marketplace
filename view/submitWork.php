<?php
session_start();
require_once("../controller/authCheck.php");
require_once("../model/applicationModel.php");

checkLoggedIn();
checkUserType("freelancer", "login.php");

$application_id = $_GET['application_id'] ?? null;
$freelancer_id = $_SESSION['user_id'];

if (!$application_id) {
    header("Location: freelancerDashboard.php");
    exit();
}

$application = getApplicationDetails($application_id, $freelancer_id, 'freelancer');
if (!$application || $application['status'] !== 'accepted') {
    echo "<script>
            alert('Invalid application or not authorized!');
            window.location.href = 'freelancerDashboard.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Work - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/jobView.css">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <section>
            <fieldset>
                <legend><h2>Job Details</h2></legend>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($application['title']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($application['description']); ?></p>
                <p><strong>Payment:</strong> $<?php echo number_format($application['payment'], 2); ?></p>
                <p><strong>Type:</strong> <?php echo ucfirst($application['job_type']); ?></p>
            </fieldset>

            <fieldset>
                <legend><h2>Submit Your Work</h2></legend>
                <form action="../controller/submitWork.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="application_id" value="<?php echo $application_id; ?>">
                    
                    <label for="work_description">Work Description:</label><br>
                    <textarea id="work_description" name="work_description" rows="6" cols="50" required 
                              placeholder="Describe the work you've completed, any challenges faced, and any additional notes..."></textarea><br><br>
                    
                    <label for="work_file">Upload Work File (Optional):</label><br>
                    <input type="file" id="work_file" name="work_file" 
                           accept=".pdf,.doc,.docx,.zip,.rar,.txt,.jpg,.jpeg,.png"><br>
                    <small>Allowed: PDF, DOC, DOCX, ZIP, RAR, TXT, JPG, PNG (Max: 10MB)</small><br><br>
                    
                    <input type="submit" value="Submit Work">
                    <input type="button" value="Cancel" onclick="window.location.href='freelancerDashboard.php'">
                </form>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>
