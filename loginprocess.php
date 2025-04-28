<?php 
session_start();
require 'config.php';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(isset($con)){
        $stmt = $con->prepare("SELECT id, password FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if(password_verify($password, $hashed_password)){
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;

                if ($email === "rkanzariya861@rku.ac.in") { 
                    header("Location: admin.php"); 
                } else {
                    header("Location: home.php"); 
                }
                exit();
            } else {
                $_SESSION['login_error'] = "Incorrect password!";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['login_error'] = "Email not found!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Database connection error!";
        header("Location: login.php");
        exit();
    }
}
$con->close();
?>
