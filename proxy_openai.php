<?php
header("Content-Type: application/json");

// Leer la clave desde la variable de entorno
$api_key = getenv("OPENAI_API_KEY");

if (!$api_key) {
    echo json_encode(["error" => "No se encontró la variable OPENAI_API_KEY en el entorno"]);
    http_response_code(500);
    exit;
}

// Leer el cuerpo del POST
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || !isset($data['model'])) {
    $data = [
        "model" => "gpt-4o-mini",
        "messages" => [
            ["role" => "user", "content" => "Hola, ¿estás funcionando correctamente?"]
        ]
    ];
}

// Inicializar cURL para la API de OpenAI
$ch = curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
} else {
    http_response_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));
    echo $response;
}

curl_close($ch);
?>
