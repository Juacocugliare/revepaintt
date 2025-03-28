<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Dirección de correo del destinatario 
$receiving_email_address = 'cugliarejuaco02@gmail.com';  

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'cugliarejuaco02@gmail.com';  
    $mail->Password   = 'cjew iolx zqmz miiv';  // Usa una app password segura
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('cugliarejuaco02@gmail.com', 'Formulario pagina web'); // Cambiar nombre visible del remitente
    $mail->addAddress($receiving_email_address);
    $mail->addReplyTo($email, $name); // Configurar "reply-to" como el email del usuario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = $subject;

    // Formato del cuerpo del mensaje
    $mail->Body    = "<strong>Nombre:</strong> {$name}<br>
                      <strong>Email:</strong> {$email}<br>
                      <strong>Asunto:</strong> {$subject}<br>
                      <strong>Mensaje:</strong> <br>" . nl2br($message);
    $mail->AltBody = "Nombre: {$name}\n
                      Email: {$email}\n
                      Asunto: {$subject}\n
                      Mensaje:\n" . strip_tags($message);

    $mail->send();

    // Respuesta para JavaScript (en formato JSON)
    echo json_encode("El mensaje ha sido enviado"); 
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}"]);
}
?>
