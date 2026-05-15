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
    <link rel="shortcut icon" href="../Imagenes/The_Shattered_Deck.ico" />
    <title>// TIRADA CORRUPTA //</title>
    <link rel="stylesheet" href="../css/lectura.css">
    <link rel="stylesheet" href="../css/tirada-roto.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../html/index.html">Inicio</a></li>
                <li><a href="../html/lectura.html">Lectura</a></li>
                <li><a href="../html/about.html">Sobre el Proyecto</a></li>
                <li><a href="../html/contacto.html">Contacto</a></li>
                <li><a href="../html/login.html">Iniciar Sesión</a></li>
                <li><a href="../html/perfil.html">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <p class="nombre-mazo">💥 mAZo r*T0</p>
            <h2 class="titulo-roto" data-text="// SEÑAL CORRUPTA //">// SEÑAL CORRUPTA //</h2>
            <p class="subtitulo-roto">elige una carta. o no. da igual. nada importa.</p>

            <div class="cartas-grid" id="cartas-grid"></div>

            <div class="separador" id="separador"></div>

            <div class="lectura-box" id="lectura-box">
                <p class="lectura-titulo">█ TR4NSMISI0N █</p>
                <div class="lectura-texto" id="lectura-texto"></div>
            </div>

            <button class="btn-nueva" id="btn-nueva" onclick="nuevaTirada()">↺ REINICIAR</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 The Shattered Deck | señal inestable</p>
    </footer>

    <script src="../js/tirada-roto.js"></script>
</body>

</html>
