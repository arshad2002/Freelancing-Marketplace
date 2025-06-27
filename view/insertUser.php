<?php
    session_start();
    require_once("../controller/AuthCheck.php");
    checkLoggedIn();
    checkUserType("admin", "Login.php");
?> 
<html>
<head>
    <title>Insert User</title>
    <script src = "../asset/js/ajaxForViewUser.js"></script>
    <link rel="stylesheet" href="../asset/css/index.css">
</head>
    
<body>
    <nav align="right">
        <a href = "AdminDashboard.php">Home |</a>
        <a href="profile.php">Profile |</a>
        <a href="Settings.php">Settings |</a>
        <a href="../controller/logoutCheck.php">Logout</a>
    </nav>
    <h3> Welcome <?php echo $_SESSION['username']; ?></h3>

    <form  id = "adminInsertForm" action="" method = "POST" >
        <input type="text" id = "uname" placeholder="Enter name"> <br> <br>
        <input type="email" id = "uemail" placeholder="Enter mail"> <br> <br>
        <input type="text" id = "upassword" placeholder="Enter password"> <br> <br>

        Select Type:<select id = "uutype" name="user_type" >
        <option value="client" >Client</option>
        <option value="freelancer">Freelancer</option>
        <option value="admin">Admin</option>
        </select> <br> <br>
        <button id = "SubmitBtn">Submit</button>
    </form>
    <div id = "showInsertMsg"></div>

</body>
</html>