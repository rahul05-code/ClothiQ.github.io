<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';


include 'config.php';

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])){

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['signup_error'] = "Invalid CSRF token!";
        header("Location: register.php");
        exit();
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if (empty($name) || empty($email) || empty($password) || empty($confirmpassword)) {
        $_SESSION['signup_error'] = "All fields are required!";
        header("Location: register.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format!";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirmpassword) {
        $_SESSION['signup_error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    if (strlen($password) < 6) {
        $_SESSION['signup_error'] = "Password must be at least 6 characters long!";
        header("Location: register.php");
        exit();
    }

    // Check if email exists
    $query = $con->prepare("SELECT id FROM users WHERE email=?");
    $query->bind_param('s', $email);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $_SESSION['signup_error'] = "Email already taken!";
        header("Location: register.php");
        exit();
    }

    $query->close();

    $otp = rand(100000, 999999);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Save pending user and OTP
    $insert = $con->prepare("INSERT INTO pending_users (name, email, password, otp) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $name, $email, $hashed_password, $otp);
    $insert->execute();
    $insert->close();

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'todo01439@gmail.com'; 
        $mail->Password = 'aqqx cwbk venj vbzu';         
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('todo01439@gmail.com', 'ClothiQ');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Verify your email - OTP Inside';
        $mail->Body = "Hello <b>$name</b>,<br>Your OTP for email verification is: <b>$otp</b><br><br>Thanks!";

        $mail->send();

        $_SESSION['signup_success'] = "OTP sent to your email. Please verify.";
        $_SESSION['verify_email'] = $email;
        header("Location: verify.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['signup_error'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: register.php");
        exit();
    }
}
?>
