<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
        .reset-container {
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

<div class="reset-container text-center">
    <h3>Reset Password</h3>

    <?php if (isset($_SESSION['reset_error'])): ?>
        <p class="text-danger"><?= $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></p>
    <?php endif; ?>

    <form action="update_password.php" method="POST">
    <input type="hidden" name="email" value="<?= $_SESSION['otp_email'] ?? '' ?>">

    <div class="mb-3 text-start">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
    </div>

    <div class="mb-3 text-start">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required minlength="6">
    </div>

    <button type="submit" class="btn btn-success w-100">Reset Password</button>
</form>
</div>

</body>
</html>
