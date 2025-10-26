<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require('connection.php');
$username = $_SESSION['username'];

$query = "SELECT * FROM carrom_boys WHERE username='$username' LIMIT 1";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome - <?php echo htmlspecialchars($username); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #2c3e50;
        padding: 15px 40px;
    }

    .navbar .logo {
        font-size: 22px;
        color: white;
        font-weight: bold;
    }

    .nav-links {
        display: flex;
        gap: 25px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .nav-links a:hover {
        color: #18bc9c;
    }

    .logout-btn {
        background-color: #e74c3c;
        border: none;
        color: white;
        padding: 8px 18px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #c0392b;
    }

    .main {
        height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: white;
    }

    .main h1 {
        font-size: 28px;
        font-weight: bold;
        color: #111;
    }

    @media (max-width: 600px) {
        .navbar {
            flex-direction: column;
            gap: 15px;
        }

        .nav-links {
            flex-direction: column;
            gap: 10px;
        }
    }
  </style>
</head>
<body>

<div class="navbar">
    <div class="logo">TJ WEBDEV</div>
    <div class="nav-links">
        <a href="#">HOME</a>
        <a href="#">BLOG</a>
        <a href="#">CONTACT</a>
        <a href="#">ABOUT</a>
    </div>
    <form action="logout.php" method="post">
        <button class="logout-btn" type="submit">LOGOUT</button>
    </form>
</div>

<div class="main">
    <h1>WELCOME TO THIS WEBSITE - <?php echo htmlspecialchars($username); ?></h1>
</div>

</body>
</html>
