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
    <title>User Profile - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/profile.css">
</head>
<body>

    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('profile');
    ?>

    <section class="profile-header">
        <h2>User Profile</h2>
        
        <?php
        // Display success or error messages
        if (isset($_SESSION['success_message'])) {
            echo '<div class="message success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
    </section>

    <div class="profile-container">
        <div class="profile-info">
            <h3>Personal Information</h3>
            <?php
                require_once("../model/userModel.php");
                $username = $_SESSION['username'];
                $user = getUserByUsername($username);
                if ($user) {
                    echo "<p><strong>Username:</strong> <span>" . htmlspecialchars($user['username']) . "</span></p>";
                    echo "<p><strong>Email:</strong> <span>" . htmlspecialchars($user['email']) . "</span></p>";
                    echo "<p><strong>User Type:</strong> <span>" . ucfirst(htmlspecialchars($user['user_type'])) . "</span></p>";
                } else {
                    echo "<p style='color: var(--accent-danger);'>Error: User not found.</p>";
                }
            ?>
        </div>
        
        <div class="profile-picture">
            <h3>Profile Picture</h3>
            <?php
            $userId = $_SESSION['user_id'];
            $profileImage = "../asset/images/$userId.png";

            // Check if the image exists, otherwise show a default image
            if (!file_exists($profileImage)) {
                $profileImage = "../asset/images/default-profile.svg";
            }

            echo "<img src='$profileImage' alt='User Profile Picture'>";
            ?>

            <!-- Upload Form -->
            <form action="../controller/uploadProfileImage.php" method="POST" enctype="multipart/form-data">
                <div class="file-input-wrapper">
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" required>
                    <label for="profile_image" class="file-input-label">
                        Choose Profile Image
                    </label>
                </div>
                <button type="submit">Upload Image</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <script src="../asset/js/profile.js"></script>
    <?php renderNavbarScript(); ?>
</body>
</html>
