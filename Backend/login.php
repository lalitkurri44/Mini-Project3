<?php require('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <span class="arrow">↗</span>
        </div>
        <h2>StockWave</h2>
        <p>Sign in to your trading account</p>
        
        <form method="POST" id="loginForm" action="login_register.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="email_username" id="username" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required  autocomplete="current-password" autocorrect="off" spellcheck="false">
            </div>
            <button type="submit" name="login">Login</button>

            <div class="footer">
                Don’t have an account? <a href="register.php">Sign up now</a>
            </div>
        </form>
    </div>
    
</body>
</html>
