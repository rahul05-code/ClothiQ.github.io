<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    echo "login_required";
    exit;
}

$email = $_SESSION['email'];
$itemId = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($itemId > 0) {
    $check = $con->prepare("SELECT * FROM favorites WHERE user_email = ? AND item_id = ?");
    $check->bind_param("si", $email, $itemId);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $del = $con->prepare("DELETE FROM favorites WHERE user_email = ? AND item_id = ?");
        $del->bind_param("si", $email, $itemId);
        $del->execute();
        echo "removed";
    } else {
        $ins = $con->prepare("INSERT INTO favorites (user_email, item_id) VALUES (?, ?)");
        $ins->bind_param("si", $email, $itemId);
        $ins->execute();
        echo "added";
    }
}
?>
