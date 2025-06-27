<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/settings.css">
    <script src="../asset/js/settingsValidation.js"></script>
</head>
<body>

    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('settings');
    ?>

    <main>
        <section class="settings-header">
            <h2>User Settings</h2>
            
            <?php
                require_once("../controller/errorShowing.php");
            ?>
        </section>

        <div class="settings-container">
            <div class="settings-card">
                <h3>Change Password</h3>
                <form action="../controller/settingsController.php" method="post" onsubmit="return validatePassword();">
                    <div class="form-group">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" id="newPassword" name="newPassword" required>
                    </div>
                    <button type="submit" name="changePassword" class="btn-primary">Change Password</button>
                </form>
            </div>

            <div class="settings-card">
                <h3>Change Email</h3>
                <form action="../controller/settingsController.php" method="post">
                    <div class="form-group">
                        <label for="newEmail">New Email:</label>
                        <input type="email" id="newEmail" name="newEmail" required>
                    </div>
                    <button type="submit" name="changeEmail" class="btn-primary">Change Email</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>
            