<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #dc3545;
            font-size: 2rem;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            font-size: 1.1rem;
            margin-bottom: 25px;
        }
        a.button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Payment Failed</h1>
    <p>Unfortunately, your payment could not be completed. Please try again or contact our support team if the issue persists.</p>
    <a href="{{ route('frontend.checkout.index') }}" class="button">Try Again</a>
</div>
</body>
</html>
