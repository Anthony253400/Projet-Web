<?php
// -------------------------
// Test FastAPI depuis PHP
// -------------------------

// Message à tester
$data = json_encode([
    "text" => "the black people are very stupid"
]);

// URL de l'API FastAPI
$url = "http://127.0.0.1:8000/analyze";

// Initialisation cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Exécution
$response = curl_exec($ch);

// Vérifie les erreurs cURL
if ($response === false) {
    echo "cURL error: " . curl_error($ch);
    exit;
}

curl_close($ch);

// -------------------------
// Affiche la réponse brute
// -------------------------
echo "Response raw:\n";
var_dump($response);
echo "\n\n";

// -------------------------
// Décode JSON
// -------------------------
$result = json_decode($response, true);

if ($result === null) {
    echo "❌ JSON invalide ou vide reçu.\n";
    exit;
}

// -------------------------
// Affiche le résultat formaté
// -------------------------
echo "Result decoded:\n";
print_r($result);

// -------------------------
// Vérifie si le message doit être bloqué
// -------------------------
$threshold = 0.7;

if (isset($result["hate"]) && $result["hate"] && isset($result["confidence"]) && $result["confidence"] > $threshold) {
    echo "❌ Message bloqué\n";
} else {
    echo "✅ Message autorisé\n";
}
