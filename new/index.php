<?php
include('connection.php');
session_start();
$user_id = 1; // Example user_id, normally from login

// Fetch current wallet balance
$query = "SELECT balance FROM wallet WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $balance = $row['balance'];
}else{
    $insert = "INSERT INTO wallet(user_id,balance) VALUES($user_id,0)";
    mysqli_query($conn, $insert);
    $balance = 0;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Wallet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">

    <h2>Your Wallet Balance: $<span id="walletBalance"><?php echo number_format($balance,2); ?></span></h2>

    <form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr" class="mt-4">
        <input type="hidden" name="business" value="sb-i43kys45478647@business.example.com">
        <input type="hidden" name="item_name" value="Wallet Deposit">
        <input type="hidden" name="item_number" value="wallet123">
        <input type="number" name="amount" placeholder="Enter amount in USD" step="0.01" min="1" class="form-control mb-3" required>
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" id="returnURL" name="return" value="http://localhost/Stock/new/wallet_success.php?amount=">
<input type="hidden" name="cancel_return" value="http://localhost/Stock/new/cancel.php">

        <button type="submit" class="btn btn-primary">Deposit Funds</button>
    </form>

    <script>
document.querySelector('form').addEventListener('submit', function() {
    var amt = document.querySelector('input[name="amount"]').value;
    document.getElementById('returnURL').value = "http://localhost/Stock/new/wallet_success.php?amount=" + amt;
});
</script>

</div>
</body>
</html>
