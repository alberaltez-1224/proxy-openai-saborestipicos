<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$proxy_url = "https://proxy-openai-saborestipicos.onrender.com/proxy_openai.php";

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "user", "content" => "Hola, ¿cómo estás?"]
    ]
];

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/json\r\n",
        "content" => json_encode($data),
        "timeout" => 30,
        "ignore_errors" => true
    ]
];

$context  = stream_context_create($options);
$response = @file_get_contents($proxy_url, false, $context);

echo "<pre>";

if ($response === FALSE) {
    echo "⚠️ Error al conectar con el proxy. \n\n";
    print_r($http_response_header ?? "Sin cabeceras HTTP");
} else {
    echo "✅ Respuesta del proxy:\n\n";
    print_r($response);
}

echo "</pre>";
?>
