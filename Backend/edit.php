<?php
include "connection.php";

// Check if 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "Invalid Request";
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM carrom_boys WHERE id=?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// If no user found
if (!$user) {
    echo "User not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - ID <?= htmlspecialchars($user['id']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }
        input[type="text"], input[type="email"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"], button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button {
            display: inline-block;
        }
        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .profile-img {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <h2>Edit User - ID <?= htmlspecialchars($user['id']); ?></h2>
    <form method="POST" action="update-user.php" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($user['contact']); ?>" required><br>

        <label for="profile">Change Profile Picture:</label>
        <input type="file" id="profile" name="profile"><br>

        <?php if ($user['profile']) { ?>
            <div class="profile-img">
                <img src="../<?= htmlspecialchars($user['profile']); ?>" width="80" style="border-radius: 50%;">
            </div>
        <?php } ?>

        <button type="submit" name="update">Update</button>
    </form>

</body>
</html>
