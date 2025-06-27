<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('inbox');
    ?>
    
    <main>
        <section class="welcome">
            <h2>Messages</h2>
            <p>Your message inbox will be displayed here.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>