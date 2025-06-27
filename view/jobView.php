<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
    checkUserType("client","login.php");
    if (isset($_GET['job_id'])) {
        $jobId = $_GET['job_id'];
        $_SESSION['jobid'] = $jobId;
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/jobView.css">
    <script src="../asset/js/clientJobView.js"></script>
    <script src="../asset/js/appliedFreelancer.js"></script>
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>
    
    <main>
        <div class="job-view-container">
            <div class="job-details-column">
                <fieldset>
                    <legend><h2>Job Details</h2></legend>
                    <div id="job"></div>
                </fieldset>
            </div>
            <div class="applications-column">
                <fieldset>
                    <legend><h2>Applied Freelancers</h2></legend>
                    <div id="applicationList"></div>
                </fieldset>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>