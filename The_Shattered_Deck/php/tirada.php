<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Imagenes/The_Shattered_Deck.ico" />
    <title>Tirada | The Shattered Deck</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/lectura.css">
    <link rel="stylesheet" href="../css/tirada.css">
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
            <p class="nombre-mazo" id="nombre-mazo"></p>
            <h2 class="titulo-tirada" id="titulo-tirada">Elige tu carta</h2>
            <p class="subtitulos subtitulo-tirada" id="subtitulo-tirada">Seis cartas te esperan. Solo una tiene tu mensaje.</p>

            <div class="cartas-grid" id="cartas-grid"></div>

            <div class="separador" id="separador"></div>

            <div class="lectura-box" id="lectura-box">
                <p class="lectura-titulo" id="lectura-titulo">✦ La lectura ✦</p>
                <div class="lectura-texto" id="lectura-texto"></div>
            </div>

            <button class="btn-nueva" id="btn-nueva" onclick="nueva_tirada()">↺ Nueva tirada</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 The Shattered Deck | Una experiencia de tarot impulsada por IA</p>
    </footer>

    <script src="../js/tirada.js"></script>
</body>

</html>
