<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'developershalcyon@gmail.com';
    $mail->Password = 'agmj fyku mpnj sbjs';  // Replace with your app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipient
    $mail->setFrom('developershalcyon@gmail.com', 'Halcyon');
    $mail->addAddress('ysonmolde03@gmail.com.com');  // Replace with your email for testing

    // Email content
    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email.';

    // Send email
    if ($mail->send()) {
        echo 'Test email sent successfully.';
    } else {
        echo 'Failed to send test email.';
    }
} catch (Exception $e) {
    echo 'Mailer Error: ' . $e->getMessage();
}
