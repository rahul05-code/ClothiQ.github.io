<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';


include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $con->real_escape_string($_POST["name"]);
    $email = $con->real_escape_string($_POST["email"]);
    $message = $con->real_escape_string($_POST["textmessage"]);

    // Save to database (optional)
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    $con->query($sql); // optional: remove this line if you only want to send email

    // Send Email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'todo01439@gmail.com'; 
        $mail->Password   = 'aqqx cwbk venj vbzu';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('todo01439@gmail.com', 'New Review Message');
        $mail->addAddress('kanzariyarahul2005@gmail.com'); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from $name";
        $mail->Body    = "<strong>Name:</strong> $name<br>
                          <strong>Email:</strong> $email<br>
                          <strong>Message:</strong><br>$message";

        $mail->send();
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Mailer Error: {$mail->ErrorInfo}'); window.location.href='contact.php';</script>";
    }

    $con->close();
} else {
    header("Location: contact.php");
    exit();
}
?>
