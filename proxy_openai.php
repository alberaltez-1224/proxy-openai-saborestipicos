<?php
// === PROXY PHP PARA OPENAI ===
// Evita bloqueo de salida desde tu hosting local

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

$input = file_get_contents("php://input");

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . getenv("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")
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $input);

$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    http_response_code(500);
    echo json_encode(["error" => $err]);
} else {
    echo $response;
}
?>
