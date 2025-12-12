<?php
global $pdo;
// backend/api/exemple.php

// 🔓 HEADERS CORS (OBLIGATOIRES)
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Gérer la requête OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$sql = "
  SELECT
    YEAR(date_mesure) AS year,
    COUNT(*) AS total
  FROM mesures
  GROUP BY year
  ORDER BY year
";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll());
