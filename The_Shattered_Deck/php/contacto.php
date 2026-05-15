<?php
// Para decir que la respuesta será json
header("Content-Type: application/json");

// Recibir los datos del fetch de contacto.html y leerlos (json_decode es para convertir a un array php)
$data = json_decode(file_get_contents("php://input"), true);

// En el caso e que faltan datos
if (!isset($data["nombre"], $data["email"], $data["mensaje"])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

// Extraer los datos
$nombre = $data["nombre"];
$email = $data["email"];
$asunto = $data["asunto"];
$mazo = $data["mazo"];
$mensaje = $data["mensaje"];

// crear contenido del log
$log = "====================\n";
$log .= "Fecha: " . date("Y-m-d H:i:s") . "\n";
$log .= "Nombre: $nombre\n";
$log .= "Email: $email\n";
$log .= "Asunto: $asunto\n";
$log .= "Mazo: $mazo\n";
$log .= "Mensaje:\n$mensaje\n";
$log .= "====================\n\n";

// guardar en archivo
file_put_contents(
    "../logs/contactos.log",
    $log,
    FILE_APPEND
);

// Responder que todo bien 
echo json_encode(["success" => true]);
?>