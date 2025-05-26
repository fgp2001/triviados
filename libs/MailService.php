<?php
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public function enviarValidacion($emailDestino, $token) {
        $mail = new PHPMailer(true);

        try {
            // datos del emisor del mail (el admin de triviados)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'triviadosmailer@gmail.com';
            $mail->Password = 'lmjt tngn pbkc ezsz';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('triviadosmailer@gmail.com', 'Triviados');
            $mail->addAddress($emailDestino);

            $mail->isHTML(true);
            $mail->Subject = 'Valida tu cuenta en Triviados y comienza a jugar!';
            $link = "http://localhost/triviados/Register/validar?token=$token";
            $mail->Body = "Gracias por registrarte. Validá tu cuenta haciendo click en el siguiente enlace:<br><a href='$link'>$link</a>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el email: {$mail->ErrorInfo}");
            return false;
        }
    }
}