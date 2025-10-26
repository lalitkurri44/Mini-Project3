<?php
$servername = "localhost";
$username = "root"; // XAMPP default
$password = "";     // XAMPP default
$dbname = "wallet_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
