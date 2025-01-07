<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS');

require("../PHPMailer-master/src/PHPMailer.php");
require("../PHPMailer-master/src/SMTP.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents('php://input');
    $json_convertido = json_decode($json, true);

    $destino = $json_convertido['email'];
    $resetToken = $json_convertido['reset_token'];
    $fromName = $json_convertido['from_name'];
    $subject_email = $json_convertido['subject_email'];
    $texto_email = $json_convertido['texto_email'];

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'mail.genesisdevstudio.com';
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->Username = 'no-reply@genesisdevstudio.com';
        $mail->Password = 'Gene@2025@sis';
        $mail->setFrom('no-reply@genesisdevstudio.com', $fromName);
        $mail->Subject = $subject_email;
        $mail->Body = $texto_email;
        $mail->addAddress($destino);

        $mail->send();
        echo json_encode(["status" => "success", "message" => "E-mail enviado com sucesso!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Erro: {$mail->ErrorInfo}"]);
    }
}
?>
