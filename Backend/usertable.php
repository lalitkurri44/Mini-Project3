<?php
include "connection.php";

// Check if 'id' and 'update' are set
if (!isset($_POST['update']) || !isset($_GET['id'])) {
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

if (isset($_POST['update'])) {
    // Sanitize user inputs
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);

    // Use old profile image by default
    $profilePath = $user['profile']; 

    // Handle profile image upload if new image is uploaded
    if (!empty($_FILES['profile']['name'])) {
        $img_loc = $_FILES['profile']['tmp_name'];
        $img_name = $_FILES['profile']['name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $img_size = $_FILES['profile']['size'] / (1024 * 1024); // size in MB

        // Allowed file extensions and size check
        $allowed_ext = ["jpg", "jpeg", "png", "webp"];
        if (!in_array($img_ext, $allowed_ext)) {
            echo "<script>alert('Invalid Image Extension. Only jpg, jpeg, png, webp allowed.');</script>";
            exit();
        }

        if ($img_size > 3) {
            echo "<script>alert('Image size is greater than 3MB');</script>";
            exit();
        }

        // Generate new image name and path
        $new_img_name = $username . "." . $img_ext;
        $img_path = "../Uploaded Images/" . $new_img_name;

        if (move_uploaded_file($img_loc, $img_path)) {
            $profilePath = "Uploaded Images/" . $new_img_name;
        } else {
            echo "<script>alert('Error uploading image');</script>";
            exit();
        }
    }

    // Update user details
    $update_query = "UPDATE carrom_boys SET 
        username=?, 
        email=?, 
        contact=?, 
        profile=? 
        WHERE id=?";
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $contact, $profilePath, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User updated successfully'); window.location.href='user-table.php';</script>";
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
?>
