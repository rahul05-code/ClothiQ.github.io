<?php
session_start();
include 'config.php'; 

if (isset($_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $_SESSION['reset_error'] = "Passwords do not match.";
        header("Location: reset_password.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $con->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        $_SESSION['login_success'] = "Password updated successfully. Please login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['reset_error'] = "Error updating password.";
        header("Location: reset_password.php");
        exit();
    }
} else {
    $_SESSION['reset_error'] = "Invalid request.";
    header("Location: reset_password.php");
    exit();
}

?>
