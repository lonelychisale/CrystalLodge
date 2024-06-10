<?php
use phpmailer\phpmailer\PHPMailer;
use phpmailer\phpmailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = htmlspecialchars($_POST['fullname']);
    $location = htmlspecialchars($_POST['location']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);
    $roomtype = htmlspecialchars($_POST['roomtype']);
    
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'Crystalslodge@outlook.com'; 
        $mail->Password = 'Malawi2024crystal'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom("Crystalslodge@outlook.com", "Room Booking" . " - " . $fullname); 
        $mail->addAddress('Crystalslodge@outlook.com', 'Crystal Lodge'); 
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Room Online Booking';
        $mail->Body = "
        <h1>Room Online Booking</h1>
        <p><strong>Full Name:</strong> {$fullname}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Check-in Time:</strong> {$checkin}</p>
        <p><strong>Check-out Time:</strong> {$checkout}</p>
        <p><strong>Room Type:</strong> {$roomtype}</p>
        ";
        
        $mail->send();
        $response = ['success' => true, 'message' => 'Booking request successfully sent!'];
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
