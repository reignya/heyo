<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

// Start session to access verification code and email
session_start();

// Check if verification code and recipient email are set
if (!isset($_SESSION['verification_code']) || !isset($_SESSION['verification_email'])) {
    echo json_encode(['success' => false, 'message' => 'Verification code or email not set.']);
    exit();
}

$recipientEmail = $_SESSION['verification_email'];
$verificationCode = $_SESSION['verification_code'];

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'developershalcyon@gmail.com';
    $mail->Password = 'gmj fyku mpnj sbjs'; // Use an app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('developershalcyon@gmail.com', 'Halcyon');
    $mail->addAddress($recipientEmail);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your Verification Code';
    $mail->Body = 'Your verification code is: <strong>' . $verificationCode . '</strong>';

    // Send the email
    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Message has been sent.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
}
