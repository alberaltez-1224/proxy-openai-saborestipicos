<?php
// ======================================
// 🌐 PROXY PHP PARA OPENAI - SABORES TÍPICOS
// Versión: GPT-4o-mini optimizada (ultra barata)
// ======================================

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔑 Leer la clave desde variable de entorno
$api_key = getenv("OPENAI_API_KEY");

if (!$api_key) {
    http_response_code(500);
    echo json_encode(["error" => "No se encontró la variable OPENAI_API_KEY en el entorno"]);
    exit;
}

// 📨 Leer el cuerpo del POST
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Si no hay datos, usar un ejemplo de prueba
if (!$data || !isset($data['messages'])) {
    $data = [
        "model" => "gpt-4o-mini",
        "max_tokens" => 300,
        "messages" => [
            ["role" => "system", "content" => "Eres un asistente SEO experto en frutas, bienestar y oficinas en Madrid."],
            ["role" => "user", "content" => "Hola, ¿estás funcionando correctamente?"]
        ]
    ];
} else {
    // Asegurarse de usar el modelo correcto
    $data["model"] = "gpt-4o-mini";
    if (!isset($data["max_tokens"])) $data["max_tokens"] = 300;
}

// 🔗 Llamada a la API de OpenAI
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ],
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_TIMEOUT => 60
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// 🧾 Mostrar resultado
if ($error) {
    http_response_code(500);
    echo json_encode(["error" => $error]);
} else {
    http_response_code($http_code);
    echo $response;
}
?>
