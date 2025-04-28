<?php
session_start();
require 'config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $email = $_SESSION['verify_email'] ?? '';
    $otp = trim($_POST['otp']);

    if (empty($otp) || empty($email)) {
        $error = "OTP or session expired!";
    } else {
        $stmt = $con->prepare("SELECT name, password FROM pending_users WHERE email=? AND otp=?");
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name, $password);
            $stmt->fetch();

            $insert = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $password);
            $insert->execute();
            $insert->close();

            $delete = $con->prepare("DELETE FROM pending_users WHERE email=?");
            $delete->bind_param("s", $email);
            $delete->execute();
            $delete->close();

            unset($_SESSION['verify_email']);
            $_SESSION['signup_success'] = "Email verified successfully! You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Invalid OTP!";
        }
        $stmt->close();
    }
}
?>

<!-- UI Section -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verify-card {
            padding: 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }
    </style>
</head>
<body>

<div class="verify-card">
    <h3 class="text-center mb-4">Email Verification</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="otp" class="form-label">Enter OTP</label>
            <input type="text" class="form-control" name="otp" id="otp" required placeholder="6-digit code">
        </div>

        <button type="submit" name="verify" class="btn btn-dark w-100">Verify</button>
    </form>

    <p class="mt-3 text-center text-muted">Didn't get the OTP? <a href="resend_otp.php">Resend</a></p>
</div>

</body>
</html>
