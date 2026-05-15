<?php

// iniciar o reanudar sesión
session_start();

// Asegurarse de que hay conexión a la base de datos
require_once("../php/db.php");


// El formato de la respuesta que enviamos
header("Content-Type: application/json");

// Leer JSON del frontend
$data = json_decode(file_get_contents("php://input"), true);

// Si han llegado los datos, o no
if (!isset($data["username"], $data["password"])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit;
}

// El trim es para eliminar espacios extra
$username = trim($data["username"]);
$password = $data["password"];

// Que pongan usuario Y contraseña
if ($username === "") {
    echo json_encode(["error" => "El usuario no puede estar vacío"]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(["error" => "La contraseña es demasiado corta"]);
    exit;
}

// hashear la contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Preparar la consulta
$consulta_enviar = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
// Ahora si que metemos el usuario y la contraseñá haseada
$consulta_enviar->bind_param("ss", $username, $password_hash);
// Ejecutamos la consulta
$consulta_enviar->execute();

// Si llegamos aquí, todo ok, es el id automático
$user_id = $conn->insert_id;

// Para quedar logeado
$_SESSION["user_id"] = $user_id;
$_SESSION["username"] = $username;

// Respuesta OK
echo json_encode([
    "success" => true,
    "user" => [
        "id" => $user_id,
        "username" => $username
    ]
]);

// Cerrar la consulta, y la sesión
$consulta_enviar->close();
$conn->close();
?>