<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .verify-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="verify-container text-center">
    <h3>Enter OTP</h3>

    <?php if (isset($_SESSION['otp_sent'])): ?>
        <p class="text-success"><?= $_SESSION['otp_sent']; unset($_SESSION['otp_sent']); ?></p>
    <?php endif; ?>

    <form action="check_otp.php" method="POST">
        <div class="mb-3 text-start">
            <label for="otp" class="form-label">OTP</label>
            <input type="text" name="otp" class="form-control" required maxlength="6" pattern="\d{6}">
        </div>
        <button type="submit" class="btn btn-dark w-100">Verify</button>
    </form>

    <p class="mt-3 text-muted">Didn’t receive it? <a href="resend_otp.php">Resend OTP</a></p>
</div>

</body>
</html>
