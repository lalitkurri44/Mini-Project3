<?php 
// connection.php include optional if you want to store wallet transactions
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Wallet Deposit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: #f7f7f7;
    }
    .deposit-card {
      max-width: 400px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    .deposit-card h2 {
      margin-bottom: 20px;
    }
    .btn-deposit {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
    }
  </style>
</head>
<body>

<div class="deposit-card">

    <h2>Add Funds to Your Wallet</h2>
    <p>Enter the amount you want to deposit and click "Deposit Funds".</p>

    <form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
        <!-- Sandbox merchant email -->
        <input type="hidden" name="business" value="sb-i43kys45478647@business.example.com">

        <!-- Dummy item details -->
        <input type="hidden" name="item_name" value="Wallet Deposit">
        <input type="hidden" name="item_number" value="wallet123">

        <!-- PayPal requires amount input -->
        <input type="number" name="amount" class="form-control mb-3" placeholder="Enter amount in USD" min="1" step="0.01" required>

        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="cmd" value="_xclick">

        <!-- Return URLs -->
        <input type="hidden" name="return" value="http://localhost/new/success.php">
        <input type="hidden" name="cancel_return" value="http://localhost/new/cancel.php">

        <!-- Deposit Button -->
        <button type="submit" class="btn btn-primary btn-deposit mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Deposit Funds
        </button>
    </form>

</div>

</body>
</html>
