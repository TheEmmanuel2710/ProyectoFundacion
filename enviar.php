<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'librerias/phpmailer/src/PHPMailer.php';
require 'librerias/phpmailer/src/SMTP.php';
require 'librerias/phpmailer/src/Exception.php';

// Llamando a los campos
$remitente = $_POST['txtRemitente'];
$destinatario = $_POST['txtDestinatario'];
$anexo_temp = $_FILES['fileAnexo']['tmp_name'];
$anexo_nombre = $_FILES['fileAnexo']['name'];
$asunto = $_POST['txtAsunto'];
$mensaje = $_POST['txtMensaje'];

// Configuración de PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fundacionnottoanswerdivininoni@gmail.com';
    $mail->Password   = 'hfyxjjycljgzygba';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('fundacionnottoanswerdivininoni@gmail.com', 'Fundacion Divino Niño');
    $mail->addAddress($destinatario);
    $mail->addReplyTo($remitente);

    if (is_uploaded_file($anexo_temp)) {
        $mail->addAttachment($anexo_temp, $anexo_nombre);
    } else {
        throw new Exception('Error al cargar el archivo adjunto.');
    }

    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;

    $mail->send();

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18"></script>';
    echo '<script>';
    echo 'Swal.fire("Fundacion Divino Niño Dice:", "El correo se envió correctamente", "success").then(function() { window.location.href = "vistaCorreo.html"; });';
    echo '</script>';
} catch (Exception $e) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18"></script>';
    echo '<script>';
    echo 'Swal.fire("Fundacion Divino Niño Dice:", "Error al enviar el correo: '.$e->getMessage().'", "error").then(function() { window.location.href = "vistaCorreo"; });';
    echo '</script>';
}
?>
