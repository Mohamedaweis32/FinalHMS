<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Make sure the path to autoload.php is correct
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];
$otp = $_POST['otp'];

// Compose the reply email with OTP
$reply_email_body = "Dear Salman,\n\n";
$reply_email_body .= "Your OTP code is: $otp\n\n";

// Send the reply email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Update with your SMTP server
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = 'maxamedawayscumar32@gmail.com'; // Your Gmail address
    $mail->Password = 'hsrfkhpggpoxwaof'; // Your Gmail password or app password

    $mail->setFrom('maxamedawayscumar32@gmail.com', 'Arman Hall'); // Update with your info
    $mail->addAddress($email, "Salman");

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = $reply_email_body;

    // Send the email
    $mail->send();

    echo 'OTP sent successfully';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>