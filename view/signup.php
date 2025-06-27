<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/signup.css">
    <script src="../asset/js/signUpValiditon.js"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <h1><a href="../index.php">FreeMarket</a></h1>
            <p>Your Gateway to Freelance Success</p>
        </div>
    </header>

    <main>
        <section class="signup-container">
            <fieldset>
                <legend><h2>Join FreeMarket Today</h2></legend>
                <form onsubmit="return validateSignUpForm();" action="../controller/checkSignup.php" method="post">
                    
                    <div class="input-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <div id="usererror" class="diverror"></div>
                    </div>
                    
                    <?php require("../controller/errorShowing.php"); ?>
                    
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <div id="emailerror" class="diverror"></div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <div id="passerror" class="diverror"></div>
                    </div>

                    <div class="input-group">
                        <label for="repassword">Confirm Password:</label>
                        <input type="password" id="repassword" name="repassword" required>
                        <div id="repasserror" class="diverror"></div>
                    </div>

                    <div class="input-group">
                        <label for="user_type">I want to join as:</label>
                        <select id="user_type" name="user_type" required>
                            <option value="client">Client (Hire freelancers)</option>
                            <option value="freelancer">Freelancer (Offer services)</option>
                        </select>
                    </div>

                    <hr>
                    <div class="actions">
                        <input type="submit" value="Create Account">
                        <a href="login.php">Already have an account? Login</a>
                    </div>
                </form>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>
</body>
</html>
