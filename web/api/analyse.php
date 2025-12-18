<?php
header('Content-Type: application/json');

$pdo = new PDO(
    'mysql:host=localhost;dbname=aquaview;charset=utf8',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Oxygène dissous
$oxygen = $pdo->query("
    SELECT 
        ROUND(AVG(valeur), 2) AS moyenne,
        ROUND(MIN(valeur), 2) AS minimum
    FROM variables
    WHERE variable_name = 'dissoxygen'
")->fetch(PDO::FETCH_ASSOC);

// Température
$temperature = $pdo->query("
    SELECT ROUND(AVG(valeur), 2)
    FROM variables
    WHERE variable_name = 'water_temp'
")->fetchColumn();

// Stations actives
$stations = $pdo->query("
    SELECT COUNT(DISTINCT sample_site)
    FROM mesures
")->fetchColumn();

echo json_encode([
    'oxygen' => $oxygen,
    'temperature_moyenne' => $temperature,
    'stations_actives' => $stations
], JSON_PRETTY_PRINT);
