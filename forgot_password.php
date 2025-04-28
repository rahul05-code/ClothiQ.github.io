<?php 
// session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f7f7f7, #eaeaea);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .forgot-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }

        .forgot-container h2 {
            margin-bottom: 25px;
            font-weight: bold;
            color: #333;
        }

        .btn-dark {
            background-color: #343a40;
            border: none;
        }

        .btn-dark:hover {
            background-color: #212529;
        }

        .form-label {
            font-weight: 500;
        }

        .text-success {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="forgot-container text-center">
    <h2>Forgot Password</h2>

    <?php if (isset($_SESSION['otp_sent'])): ?>
        <p class="text-success"><?= $_SESSION['otp_sent']; unset($_SESSION['otp_sent']); ?></p>
    <?php endif; ?>

    <form action="send_otp.php" method="POST">
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Enter your email address</label>
            <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Send OTP</button>
    </form>
</div>

</body>
</html>
