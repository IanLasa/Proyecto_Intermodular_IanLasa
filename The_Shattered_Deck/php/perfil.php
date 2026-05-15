<?php
session_start();

// Si no hemos iniciado sesión, nos lleva a login
if (!isset($_SESSION["user_id"])) {
    header("Location: /html/login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | The Shattered Deck</title>

    <link rel="stylesheet" href="../css/perfil.css">
</head>

<body>

<div class="perfil-container">

    <div class="perfil-card">

        <h1>PERFIL</h1>

        <p class="username">
            👤 <?php echo htmlspecialchars($_SESSION["username"]); ?>
        </p>

        <div class="info">
            <p>🔮 Has desbloqueado el <b>mazo corrupto</b></p>
            <p>Gracias por apoyar The Shattered Deck</p>
        </div>

        <div class="actions">

            <button onclick="location.href='../html/lectura.html'">
                IR AL TAROT
            </button>

            <button onclick="location.href='../html/index.html'">
                VOLVER AL INICIO
            </button>

            <button onclick="location.href='/php/logout.php'">
                CERRAR SESIÓN
            </button>

        </div>

    </div>

</div>

</body>
</html>