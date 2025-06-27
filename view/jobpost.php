<?php
    session_start();
    require_once("../controller/authCheck.php");
    checkLoggedIn();
    checkUserType("client","login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <div>
            <table cellspacing="0" align="center">
                <tr height="10%">
                    <td>
                        <fieldset>
                            <legend><h2>Post a Job</h2></legend>
                            <form action="../controller/clientJobsPost.php" method="post" onsubmit="return jobPostValidition();">
                                <label>Job Title:</label><br>
                                <input type="text" id="title" name="title"><br><br>
                                
                                <label>Job Description:</label><br>
                                <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
                            
                                <label>Job Type:</label><br>
                                <input type="radio" id="hourly" name="job_type" value="hourly" checked>
                                <label>Hourly</label><br>
                                <input type="radio" id="fixed" name="job_type" value="fixed">
                                <label>Fixed</label><br><br>
                            
                                <label>Payment Amount:</label><br>
                                <input type="number" id="payment" name="payment" step="0.01"><br><br>
                            
                                <input type="submit" value="Submit">
                            </form>
                            <?php require("../controller/errorShowing.php");?>
                        </fieldset>
                    </td> 
                </tr>
            </table> 
        </div>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <script src="../asset/js/jobPostValidation.js"></script>
    <?php renderNavbarScript(); ?>
</body>
</html>
