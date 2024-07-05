<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="logo.png" rel="icon">
    <link href="logo.png" rel="apple-touch-icon">
    <title>Payment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .animation {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .spinner {
            border: 8px solid #f3f3f3; /* Light grey */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        // Mendapatkan nilai dari parameter URL
        $status_code = isset($_GET['status_code']) ? $_GET['status_code'] : null;
        $transaction_status = isset($_GET['transaction_status']) ? $_GET['transaction_status'] : null;

        // Menentukan status pembayaran berdasarkan nilai parameter URL
        if ($status_code == 200 && $transaction_status == 'settlement') {
            echo "<h2>Payment Status: Success</h2>";
            echo "<div class='animation'>
                    <div class='spinner'></div>
                  </div>";
        } else {
            echo "<h2>Payment failed or was canceled.</h2>";
            echo "<div class='animation'>
                    <div class='spinner'></div>
                  </div>";
        }
        ?>
        <a href="/" class="button">Return to Home</a>
    </div>
</body>
</html>
