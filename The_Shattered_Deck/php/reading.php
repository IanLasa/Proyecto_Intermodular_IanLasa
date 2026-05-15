<?php

// IMPORTANTE
// Si, lo admito, el php lo he mirado en gran parte...


// Decirle al navegador que la respuesta será JSON en UTF-8
header("Content-Type: application/json; charset=utf-8");
// Permitir que cualquier origen pueda hacer peticiones a este archivo
header("Access-Control-Allow-Origin: *");

//Configuración 
// Dirección de Ollama dentro de la VM
$ollama_url = "http://192.168.56.102:11434/api/generate";
// Modelo de IA a utilizar
$modelo     = "phi3:mini";
// 

// Recoger los datos enviados desde el JS via FormData
// El ?? es un fallback — si no llega el campo, usa el valor por defecto
$carta = $_POST['carta'] ?? 'El Loco';
$mazo  = $_POST['mazo']  ?? 'mystic';

// Prompt distinto para cada mazo — le dice a la IA cómo debe responder
$prompts = [
    "mystic"    => "Responde en español con UNA sola frase corta, poética y mística sobre la carta de tarot \"$carta\". Termina la frase con punto. Solo una frase:",
    "rational"  => "Responde en español con UNA sola frase corta y analítica sobre la carta de tarot \"$carta\" desde la psicología. Termina la frase con punto. Solo una frase:",
    "sarcastic" => "Responde en español con UNA sola frase corta y sarcástica sobre la carta de tarot \"$carta\". Termina la frase con punto. Solo una frase:",
    "roto"      => "Responde en español con UNA frase críptica, fragmentada y sin sentido aparente sobre la carta \"$carta\". Mezcla conceptos contradictorios. Solo una frase:"
];

// Elegir el prompt según el mazo recibido, si no existe usa el místico por defecto
$prompt = $prompts[$mazo] ?? $prompts['mystic'];

// Construir el cuerpo de la petición que se enviará a Ollama en formato JSON
$payload = json_encode([
    "model"   => $modelo,
    "prompt"  => $prompt,
    "stream"  => false,   // Esperar a que termine de generar antes de devolver la respuesta
    "options" => [
        "temperature" => 0.8,  // Creatividad: 0 = robótico, 1 = muy aleatorio
        "num_predict" => 80,   // Máximo de tokens (palabras/fragmentos) a generar
        "num_ctx"     => 512,  // Tamaño del contexto que el modelo puede leer
        "stop"        => ["\n", "2)", "1)"]  // Para la generación si encuentra estos caracteres
    ]
]);

// Iniciar una petición HTTP con cURL apuntando a Ollama
$ch = curl_init($ollama_url);

// Que cURL devuelva la respuesta en vez de imprimirla directamente
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Usar método POST
curl_setopt($ch, CURLOPT_POST,           true);

// El cuerpo de la petición es el JSON que construimos antes
curl_setopt($ch, CURLOPT_POSTFIELDS,     $payload);

// Indicar que el contenido que enviamos es JSON
curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: application/json"]);

// Tiempo a espera
curl_setopt($ch, CURLOPT_TIMEOUT,        300);

// Ejecutar la petición y guardar la respuesta
$resultado = curl_exec($ch);

// Guardar si hubo algún error de conexión
$error     = curl_error($ch);

// Cerrar la conexión cURL y liberar memoria
curl_close($ch);

// Si cURL dio error (VM apagada, puerto cerrado, timeout...) devolver el error y parar
if ($error) {
    echo json_encode(["lectura" => "Error de conexión con la IA: $error"]);
    exit;
}

// Convertir la respuesta JSON de Ollama a un array de PHP
$datos = json_decode($resultado, true);

// Si Ollama devolvió una respuesta válida
if (isset($datos['response'])) {
    // Eliminar espacios y saltos de línea al inicio y al final
    $texto = trim($datos['response']);

    // Si el texto no termina en signo de puntuación (frase cortada a mitad)
    if (!str_ends_with($texto, '.') && !str_ends_with($texto, '!') && !str_ends_with($texto, '?')) {
        // Buscar la posición del último signo de puntuación que haya
        $ultimo_punto = max(strrpos($texto, '.'), strrpos($texto, '!'), strrpos($texto, '?'));
        // Si encontró alguno, cortar el texto ahí para que no quede a medias
        if ($ultimo_punto !== false) {
            $texto = substr($texto, 0, $ultimo_punto + 1);
        }
    }

    // Devolver la lectura al JS como JSON
    echo json_encode(["lectura" => $texto]);
} else {
    // Si Ollama no devuelve respuesta, mensaje alternativo
    echo json_encode(["lectura" => "Las cartas guardan silencio esta vez..."]);
}
?>