<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../controller/authCheck.php");
checkLoggedIn();
checkUserType("freelancer", "login.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/client.css">
    <!-- Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard', true, '../controller/searchJobController.php', 'Search jobs by title or description');
    ?>

    <main>
        <section class="welcome">
            <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        </section>
        
        <section class="job-section">
            <fieldset>
                <legend><h2>Available Jobs</h2></legend>
                <div id="jobList"></div>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket Freelancer Dashboard. All Rights Reserved.</p>
    </footer>

    <script src="../asset/js/freelancerJobview.js"></script>
    <?php renderNavbarScript(); ?>
</body>
</html>
