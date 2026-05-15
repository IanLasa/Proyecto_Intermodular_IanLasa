<?php

// db porque estamos en docker
$host = "db";
// Usuario admin
$user = "root";
$password = "root";
// La base de datos que he creado
$database = "miproyecto";

// Establecer conexión
$conn = new mysqli($host, $user, $password, $database);

// Si hubiese error
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>