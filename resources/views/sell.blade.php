<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sell Cryptocurrency Form</title>
  <style>
    /* Optional styling for better form presentation */
    form {
      display: flex;
      flex-direction: column;
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"], input[type="number"], input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    h1 {
        text-align: center;
    }
  </style>
</head>
<body>
  <h1>Sell</h1>
  <form action="/api/post-sells" method="post">
    <label for="currency">Currency:</label>
    <input type="text" id="currency" name="currency" placeholder="Enter currency name" required>

    <label for="rate">Rate:</label>
    <input type="number" id="rate" name="rate" step="0.0001" min="0" placeholder="Enter exchange rate" required>

    {{-- <label for="date">Date & Time:</label>
    <input type="datetime-local" id="date" name="date" required>   --}}
    
    <label for="qty">Quantity:</label>
    <input type="number" id="qty" name="qty" min="0" placeholder="Enter quantity to sell" required>

    <label for="transaction_type">Transaction Type:</label>
    <input type="text" id="transaction_type" name="transaction_type" placeholder="Enter transaction type (e.g., Market Sell, Limit Sell)" required>

    <button type="submit">Purchase Currency</button>
  </form>
</body>
</html>
