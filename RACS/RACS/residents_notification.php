<?php

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send notification email
function sendNotificationEmail($to, $visitor_name, $visitor_address) {
    $subject = "Visitor Notification: $visitor_name is requesting permission to visit";
    $message = "Dear Resident,\n\n";
    $message .= "$visitor_name is requesting permission to visit the gated community at $visitor_address.\n\n";
    $message .= "Please login to approve or deny the visit.\n\n";
    $message .= "Thank you,\n";
    $message .= "RACS";

    try {
        // Initialize PHPMailer
        $phpmailer = new PHPMailer(true);
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;  // Use 587 for TLS
        $phpmailer->SMTPSecure = 'tls';  // Use TLS encryption
        $phpmailer->Username = 'ameerassolihin@gmail.com'; // Change to your email
        $phpmailer->Password = 'rrpz clhp knlr cgdp';  // Change to your password

        // Recipients
        $phpmailer->setFrom('RACS@gmail.com', 'RACS');
        $phpmailer->addAddress($to);

        // Content
        $phpmailer->isHTML(false);  // Set email format to plain text
        $phpmailer->Subject = $subject;
        $phpmailer->Body    = $message;

        $phpmailer->send();
    } catch (Exception $e) {
        echo "Error: {$phpmailer->ErrorInfo}";
    }
}

?>