<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $resetToken = $_POST["reset_token"];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'h64.servidorhh.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@genesisdevstudio.com';
        $mail->Password = 'Gene@2025@sis';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@genesisdevstudio.com', 'APP Meu Barbeiro');
        $mail->addAddress($email);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body = "Seu código de recuperação é: $resetToken.\n\nEle expira em 10 minutos.\nCaso não tenha solicitado a recuperação de senha, ignore este e-mail.";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "E-mail enviado com sucesso!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Erro: {$mail->ErrorInfo}"]);
    }
}
?>
