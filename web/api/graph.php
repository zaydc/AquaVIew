<?php
/**
 * API Graphique – AquaView
 * Objectif : fournir des données agrégées pour les graphiques
 * Optimisations :
 *  - agrégation mensuelle
 *  - volume de données réduit
 *  - requête SQL unique
 *  - cache HTTP
 */

header('Content-Type: application/json');
header('Cache-Control: public, max-age=60'); // cache 60 secondes

// Connexion à la base de données
$pdo = new PDO(
    'mysql:host=localhost;dbname=aquaview;charset=utf8',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

// ==============================
// Paramètres
// ==============================
$metric = $_GET['metric'] ?? 'dissoxygen';

// Sécurité : liste blanche
$allowedMetrics = ['dissoxygen', 'water_temp', 'salinity', 'ph'];
if (!in_array($metric, $allowedMetrics)) {
    http_response_code(400);
    echo json_encode(['error' => 'Metric non autorisée']);
    exit;
}

// ==============================
// Requête SQL optimisée
// ==============================
$sql = "
    SELECT
        DATE_FORMAT(m.date_mesure, '%Y-%m') AS date,
        ROUND(AVG(v.valeur), 2) AS valeur
    FROM variables v
    JOIN mesures m ON v.mesure_id = m.id
    WHERE v.variable_name = :metric
      AND v.valeur > 0
    GROUP BY DATE_FORMAT(m.date_mesure, '%Y-%m')
    ORDER BY date
";

// ==============================
// Exécution
// ==============================
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'metric' => $metric
]);

$data = $stmt->fetchAll();

// ==============================
// Réponse JSON
// ==============================
echo json_encode($data, JSON_PRETTY_PRINT);
