<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
    checkUserType("freelancer","login.php");
    if (isset($_GET['job_id'])) {
        $jobId = $_GET['job_id'];
        $_SESSION['jobid'] = $jobId;
        $freelancerId = $_SESSION['user_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/jobView.css">
    <script src="../asset/js/freelancerViewJob.js"></script>
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <section>
            <fieldset>
                <legend><h2>Job Info</h2></legend>
                <div id="job"></div>
            </fieldset>
            <fieldset>
                <legend><h2>Application Status</h2></legend>
                <div align="center">
                    <?php
                        require_once("../model/applicationModel.php");
                        $status = fetchStatus($jobId, $freelancerId);
                        echo ucfirst($status);
                    ?>
                </div>
            </fieldset>
            <?php
                require_once("../model/applicationModel.php");
                
                if(!checkReApply($jobId, $freelancerId)){
                    echo "<fieldset>
                        <legend><h2>Apply to Job</h2></legend>
                        <form action='../controller/FreelancerJobApply.php' method='post' enctype='multipart/form-data'>
                            
                            <label>Application Text:</label><br>
                            <textarea id='description' name='description' rows='4' cols='50' required></textarea><br><br>
                            
                            <label>Upload CV (PDF only):</label><br>
                            <input type='file' name='cv_file' accept='.pdf' required><br><br>
                            <small>Note: Only PDF files are allowed. Maximum file size: 5MB</small><br><br>
                            
                            <input type='submit' value='Apply'>
                        </form>
                    </fieldset>";
                }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>