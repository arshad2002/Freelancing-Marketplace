<?php
    session_start();
    require_once("../controller/AuthCheck.php");
    checkLoggedIn();
    checkUserType("admin", "Login.php");
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users - FreeMarket Admin</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <script src="../asset/js/ajaxForViewUser.js"></script>
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <section>
            <fieldset>
                <legend><h2>User Management</h2></legend>
                <div class="welcome-message">
                    <h3>Welcome <?php echo $_SESSION['username']; ?></h3>
                </div>
                
                <div class="user-controls">
                    <label for="user_type">Select User Type:</label>
                    <select id="user_type" name="user_type">
                        <option value="client">Client</option>
                        <option value="freelancer">Freelancer</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button id="viewUserBtn">View Users</button>
                </div>
                
                <div id="showUserlist"></div>
                <div id="deltemsg"></div>
                
                <hr>
                
                <div id="editPannel">
                    <h3>Edit User</h3>
                    <form action="editForm" method="POST">
                        <input type="hidden" id="editFormID">
                        <div class="input-group">
                            <input type="text" id="editFormName" placeholder="Enter Name">
                        </div>
                        <div class="input-group">
                            <input type="email" id="editFormEmail" placeholder="Enter Email">
                        </div>
                        <div class="input-group">
                            <input type="password" id="editFormPassWord" placeholder="Enter Password">
                        </div>
                        <button id="EditSave" type="button">Save Changes</button>
                    </form>
                    <div id="showEditMsg"></div>
                </div>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>