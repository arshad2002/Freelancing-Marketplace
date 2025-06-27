<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert User - FreeMarket Admin</title>
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
                <legend><h2>Add New User</h2></legend>
                <div class="welcome-message">
                    <h3>Welcome <?php echo $_SESSION['username']; ?></h3>
                </div>

                <form id="adminInsertForm" action="" method="POST">
                    <div class="input-group">
                        <input type="text" id="uname" placeholder="Enter Name" required>
                    </div>
                    <div class="input-group">
                        <input type="email" id="uemail" placeholder="Enter Email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="upassword" placeholder="Enter Password" required>
                    </div>
                    <div class="input-group">
                        <label for="uutype">Select User Type:</label>
                        <select id="uutype" name="user_type" required>
                            <option value="client">Client</option>
                            <option value="freelancer">Freelancer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button id="SubmitBtn" type="button">Add User</button>
                </form>
                <div id="showInsertMsg"></div>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>