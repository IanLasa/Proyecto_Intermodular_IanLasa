<?php
header("Content-Type: application/json; charset=utf-8");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/vendor/autoload.php';

// ── Datos del formulario ───────────────────────────────────
$nombre  = htmlspecialchars(trim($_POST['nombre']  ?? ''));
$email   = htmlspecialchars(trim($_POST['email']   ?? ''));
$asunto  = htmlspecialchars(trim($_POST['asunto']  ?? ''));
$mazo    = htmlspecialchars(trim($_POST['mazo']    ?? 'Ninguno'));
$mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

if (!$nombre || !$email || !$asunto || !$mensaje) {
    echo json_encode(["ok" => false, "error" => "Faltan campos obligatorios."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["ok" => false, "error" => "Email no válido."]);
    exit;
}

// ── Configuración SMTP ─────────────────────────────────────
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ilasallore@educacion.navarra.es';
    $mail->Password   = 'zpiddbjfvdbbzdsf';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // ── Remitente y destinatario ───────────────────────────
    $mail->setFrom('ilasallore@educacion.navarra.es', 'The Shattered Deck');
    $mail->addAddress('ilasallore@educacion.navarra.es', 'The Shattered Deck');
    $mail->addReplyTo($email, $nombre);

    // ── Contenido del email ────────────────────────────────
    $mail->isHTML(true);
    $mail->Subject = "[Shattered Deck] $asunto — $nombre";
    $mail->Body    = "
        <div style='font-family: monospace; background: #0a0a0a; color: #eee; padding: 2rem; border: 1px solid #6c63ff;'>
            <h2 style='color: #6c63ff; letter-spacing: 2px;'>// NUEVO MENSAJE //</h2>
            <hr style='border-color: #333; margin: 1rem 0;'>
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Asunto:</strong> $asunto</p>
            <p><strong>Mazo:</strong> $mazo</p>
            <hr style='border-color: #333; margin: 1rem 0;'>
            <p><strong>Mensaje:</strong></p>
            <p style='color: #ccc; line-height: 1.8;'>$mensaje</p>
        </div>
    ";

    $mail->send();
    echo json_encode(["ok" => true]);

} catch (Exception $e) {
    echo json_encode(["ok" => false, "error" => $mail->ErrorInfo]);
}
?>
