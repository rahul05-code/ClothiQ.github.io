<?php
session_start();

if ($_POST['otp'] == $_SESSION['otp']) {
    $_SESSION['otp_verified'] = true;
    header("Location: reset_password.php");
} else {
    echo "Invalid OTP. <a href='verify_otp.php'>Try again</a>";
}
?>
