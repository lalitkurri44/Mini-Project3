<?php
include('connection.php');
session_start();
$user_id = 1; // Example user_id

// Amount passed via GET (for demo purpose)
$amount = $_GET['amount'] ?? 10; // default 10 USD if not passed

// Update wallet balance
if($amount > 0){
    $update = "UPDATE wallet SET balance = balance + $amount WHERE user_id = $user_id";
    mysqli_query($conn, $update);
}

// Fetch updated balance
$query = "SELECT balance FROM wallet WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$balance = $row['balance'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Deposit Success</title>
  <meta charset="utf-8">
</head>
<body>
<div class="container mt-5 text-center">
    <h2>Deposit Successful!</h2>
    <p>Your updated wallet balance is: $<?php echo number_format($balance,2); ?></p>
    <a href="../Backend/pure.php">Back to Wallet</a>
</div>
</body>
</html>
