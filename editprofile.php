<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['email'] == 'unset') {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];
$name = trim($_POST['name']);
$gender = $_POST['gender'];
$phone_no = trim($_POST['phone_no']);
$address = trim($_POST['address']);

// Fetch current profile_pic if exists
$currentQuery = "SELECT profile_pic FROM edituser WHERE email = ?";
$currentStmt = $con->prepare($currentQuery);
$currentStmt->bind_param("s", $email);
$currentStmt->execute();
$currentResult = $currentStmt->get_result();
$currentUser = $currentResult->fetch_assoc();

$profile_pic = $currentUser['profile_pic'] ?? 'default.png'; // default fallback

// Profile picture handling
if (!empty($_FILES['profile_pic']['name'])) {
    $target_dir = "photo/uploads/";
    $file_name = basename($_FILES["profile_pic"]["name"]);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $target_file = $target_dir . time() . "_" . uniqid() . "." . $file_ext;

    $allowed_exts = ["jpg", "jpeg", "png"];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($file_ext, $allowed_exts)) {
        $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG allowed.";
        header("Location: dashbord.php");
        exit();
    }

    if ($_FILES["profile_pic"]["size"] > $max_size) {
        $_SESSION['error'] = "File size exceeds 2MB limit.";
        header("Location: dashbord.php");
        exit();
    }

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Delete old picture if not default
        if ($profile_pic != 'default.png' && file_exists("photo/uploads/" . $profile_pic)) {
            unlink("photo/uploads/" . $profile_pic);
        }

        $profile_pic = basename($target_file); // Store just the filename
    } else {
        $_SESSION['error'] = "Error uploading file.";
        header("Location: dashbord.php");
        exit();
    }
}

// Check if user exists
$checkQuery = "SELECT email FROM edituser WHERE email = ?";
$stmt = $con->prepare($checkQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update existing user
    $updateQuery = "UPDATE edituser SET name=?, gender=?, phone_no=?, address=?, profile_pic=? WHERE email=?";
    $updateStmt = $con->prepare($updateQuery);
    $updateStmt->bind_param("ssssss", $name, $gender, $phone_no, $address, $profile_pic, $email);

    if ($updateStmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating profile.";
    }
} else {
    // Insert new user
    $insertQuery = "INSERT INTO edituser (name, email, gender, phone_no, address, profile_pic, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $insertStmt = $con->prepare($insertQuery);
    $insertStmt->bind_param("ssssss", $name, $email, $gender, $phone_no, $address, $profile_pic);

    if ($insertStmt->execute()) {
        $_SESSION['success'] = "Profile created successfully!";
    } else {
        $_SESSION['error'] = "Error creating profile.";
    }
}

header("Location: dashbord.php");
exit();
?>
