<?php
session_start(); // Start the session at the very beginning

require('connection.php'); // Database connection

if (isset($_POST['login'])) {
    $email_username = mysqli_real_escape_string($con, $_POST['email_username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM carrom_boys WHERE email='$email_username' OR username='$email_username'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $result_fetch = mysqli_fetch_assoc($result);

        if (password_verify($password, $result_fetch['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $result_fetch['username'];
            $_SESSION['profile'] = $result_fetch['profile']; // profile image
            $_SESSION['login_time'] = date("Y-m-d H:i:s"); // login time

            header("Location: pure.php"); // Redirect to welcome page
            exit(); // Stop further script execution
        } else {
            echo "<script>
                alert('Incorrect password');
                window.location.href='login.php';
                </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Email or username not registered');
            window.location.href='register.php';
            </script>";
        exit();
    }
}







if (isset($_POST['register'])) {
    include "../config.php"; // go one level up if config is outside carrom

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $user_exists_query = "SELECT * FROM carrom_boys WHERE username='$username' OR email='$email'";
    $result = mysqli_query($con, $user_exists_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if ($result_fetch['username'] == $username) {
                echo "<script>alert('$username - Username already taken'); window.location.href='register.php';</script>";
            } else {
                echo "<script>alert('$email - Email already taken'); window.location.href='register.php';</script>";
            }
        } else {
            // Insert user first
            $query = "INSERT INTO carrom_boys (username, email, password, contact) 
                      VALUES ('$username', '$email', '$password', '$contact')";

            if (mysqli_query($con, $query)) {
                // Proceed with image upload
                $img_loc = $_FILES['profile']['tmp_name'];
                $img_name = $_FILES['profile']['name'];
                $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                $img_size = $_FILES['profile']['size'] / (1024 * 1024); // size in MB

                $allowed_ext = ["jpg", "jpeg", "png", "webp"];
                if (!in_array($img_ext, $allowed_ext)) {
                    echo "<script>alert('Invalid Image Extension');</script>";
                    exit();
                }

                if ($img_size > 3) {
                    echo "<script>alert('Image size is greater than 3MB');</script>";
                    exit();
                }

                // Create destination paths
                $new_img_name = $username . "." . $img_ext;
                $main_path = "../Uploaded Images/" . $new_img_name;  // project root
                $local_path = "Uploaded Images/" . $new_img_name;    // carrom folder
                $img_url_for_db = "Uploaded Images/" . $new_img_name;

                // Ensure both folders exist
                if (!is_dir("../Uploaded Images")) mkdir("../Uploaded Images", 0777, true);
                if (!is_dir("Uploaded Images")) mkdir("Uploaded Images", 0777, true);

                // Move image to both locations
                if (move_uploaded_file($img_loc, $main_path)) {
                    copy($main_path, $local_path); // duplicate copy in carrom folder

                    // Update profile path in DB
                    $upload_query = "UPDATE carrom_boys SET profile='$img_url_for_db' WHERE username='$username'";
                    if (mysqli_query($con, $upload_query)) {
                        echo "<script>
                            alert('Registered Successfully with Profile Picture');
                            window.location.href='login.php';
                            </script>";
                    } else {
                        echo "<script>alert('Profile update failed'); window.location.href='register.php';</script>";
                    }
                } else {
                    echo "<script>alert('Image upload failed'); window.location.href='register.php';</script>";
                }
            } else {
                echo "<script>alert('User registration failed'); window.location.href='register.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Database error'); window.location.href='register.php';</script>";
    }
}

?>