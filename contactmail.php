
<?php
use phpmailer\phpmailer\PHPMailer;
use phpmailer\phpmailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    
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
        $mail->setFrom("Crystalslodge@outlook.com", " Crystal Lodge contact " ); 
        $mail->addAddress('Crystalslodge@outlook.com', 'Crystal Lodge'); 
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject . "-" . $email;
        $mail->Body = "
        <h3>Web Contact message  from {$email}</h3>
        <p> {$message}</p>
        ";
        
        $mail->send();
        $response = ['success' => true, 'message' => 'Your contact message successfully sent!'];
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

