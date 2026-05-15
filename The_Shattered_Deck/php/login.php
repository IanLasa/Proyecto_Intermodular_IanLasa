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

// Preparar la consulta
$consulta_enviar = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
// Ahora si que metemos el usuario
$consulta_enviar->bind_param("s", $username);
// Ejecutamos la consulta
$consulta_enviar->execute();

// Conseguir el resultado de la consulta
$resultado = $consulta_enviar->get_result();

// Si no devuelve ninguna fila, es que el usuario no existe
if ($resultado->num_rows === 0) {
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit;
}

// Si hay usuario, lo convertimos a array
$user = $resultado->fetch_assoc();

// Verificar contraseña
if (!password_verify($password, $user["password_hash"])) {
    echo json_encode(["error" => "Contraseña incorrecta"]);
    exit;
}

// Crear sesión
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];

// Respuesta OK
echo json_encode([
    "success" => true,
    "user" => [
        "id" => $user["id"],
        "username" => $user["username"]
    ]
]);

// Cerrar la consulta, y la sesión
$consulta_enviar->close();
$conn->close();
?>