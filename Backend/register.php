<?php require ('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="login_register.php" enctype="multipart/form-data">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required  autocomplete="current-password" autocorrect="off" spellcheck="false">
            </div>
            <div class="input-group">
                <label for="contact">Contact</label>
                <input type="tel" name="contact" pattern="[0-9]{10}" title="Enter a valid 10-digit phone number" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="photo">Upload Photo</label>
                <input type="file" name="profile" accept="image/*" required>
                <small>Accepted formats: JPG, JPEG, PNG, GIF. Max size: 2MB.</small>
            </div>
            
            <button type="submit" name="register">Register</button>
            <div class="footer">
                Already have an account..? 
                <br>
                <a 
                href="login.php">Login now</a>
            </div>
        </form>
    </div>
</body>
</html>

