<?php
    session_start();
    require_once("../controller/AuthCheck.php");
    checkLoggedIn();
    checkUserType("admin", "Login.php");
?> 
<html>
<head>
    <title>View User</title>
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

    <h3>Welcome <?php echo $_SESSION['username'];?></h3>

    
    Select User-Type: <select id = "user_type" name="user_type" >
        <option value="client" >Client</option>
        <option value="freelancer">Freelancer</option>
        <option value="admin">Admin</option>
    </select>
    <button id = "viewUserBtn">View</button> <br> <br>
    <div id = "showUserlist"></div> <br>
    <div id = "deltemsg" > </div>
    <hr>
    <div id = "editPannel">
        <h3>Edit Pannel</h3>
        <form action="editForm" method = "POST">
            <input type="text" id="editFormID" style="display:none;">
            <input type="text" id="editFormName" placeholder="Enter Name"> <br> <br>
            <input type="text" id="editFormEmail" placeholder="Enter Email"> <br> <br>
            <input type="text" id="editFormPassWord" placeholder="Enter Password"> <br> <br>
            <button id = "EditSave">Save</button>
        </form>
        <div id = "showEditMsg"></div>
     </div>

</body>
</html>