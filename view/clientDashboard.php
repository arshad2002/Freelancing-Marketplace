<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
    checkUserType("client","login.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/client.css">
    <link rel="stylesheet" href="../asset/css/searchFreelancer.css">
    <!-- Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard', true, '../controller/searchFreelancer.php', 'Search freelancers by username or ID');
    ?>

    <main>
        <section class="welcome">
            <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
            <button class="btn-primary" onclick="redirectToJobPost()">Post a Job</button>
            <script>function redirectToJobPost() {window.location.href = 'jobpost.php';}</script>
        </section>

        <section class="search">
            <!-- Search functionality moved to navbar -->
        </section>

        <section class="jobs">
            <fieldset>
                <legend><h2>Posted Jobs</h2></legend>
                <div id="jobList"></div>
            </fieldset>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <script src="../asset/js/clientPostedJob.js"></script>
    <script src="../asset/js/searchFreelancer.js"></script>
    <?php renderNavbarScript(); ?>
</body>
</html>
