<?php
session_start();

// borrar variables de sesión
$_SESSION = [];

// destruir sesión
session_destroy();

// redirigir al login
header("Location: /html/login.html");
exit;
?>