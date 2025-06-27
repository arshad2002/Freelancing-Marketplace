<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/login.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><a href="../index.php">FreeMarket</a></h1>
            <p>Your Gateway to Freelance Success</p>
        </div>
    </header>

    <main>
        <section class="login-container">
            <fieldset>
                <legend><h2>Login to FreeMarket</h2></legend>
                <form action="../controller/checkLogin.php" method="post">
                    <div class="input-group">
                        <label for="username"><b>Username:</b></label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password"><b>Password:</b></label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <?php require("../controller/errorShowing.php");?>
                    <hr>
                    <div class="actions">
                        <input type="submit" value="Login">
                        <a href="../view/signup.php">Create Account</a>
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
