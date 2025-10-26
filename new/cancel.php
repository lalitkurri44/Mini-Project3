<?php
session_start();
$user_id = 1; // Example user_id

include('connection.php');

// Fetch current wallet balance (unchanged)
$query = "SELECT balance FROM wallet WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$balance = $row['balance'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Deposit Cancelled</title>
  <meta charset="utf-8">
</head>
<body>
<div class="container mt-5 text-center">
    <h2>Deposit Cancelled!</h2>
    <p>Your wallet balance remains: $<?php echo number_format($balance,2); ?></p>
    <a href="wallet.php">Back to Wallet</a>
</div>
</body>
</html>
