<?php
/**
 * API d'analyse des donnees oceaniques
 * BUT2 - S3 - AquaView Project
 * Endpoint REST pour recuperer les donnees d'analyse en temps reel
 */

declare(strict_types=1);

// ==========================
// Configuration du gestionnaire d'erreurs
// ==========================
error_reporting(E_ALL);
ini_set('display_errors', '0'); // En production, ne pas afficher les erreurs

// ==========================
// Autoloader PSR-4 pour le chargement auto des classes
// ==========================
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

// Configuration de l'autoloader avec le namespace App
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

// Definition de l'en-tete pour les reponses JSON
header('Content-Type: application/json; charset=utf-8');

// ==========================
// Gestionnaire d'erreurs centralise pour l'API
// ==========================
function handleApiError(string $message, array $details = [], int $statusCode = 500) {
    // Definition du code de statut HTTP
    http_response_code($statusCode);
    // Generation de la reponse d'erreur structuree
    echo json_encode([
        'error' => $message,
        'details' => $details,
        'timestamp' => date('c') // Format ISO 8601
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ==========================
// Imports
// ==========================
use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

// ==========================
// Paramètres reçus
// ==========================
try {
    $metric = $_GET['metric'] ?? 'dissoxygen';
    
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;
    $years = isset($_GET['periode']) ? (int)$_GET['periode'] : null;

    // ==========================
    // Construction des filtres
    // ==========================
    if ($startDate || $endDate) {
        $wherePeriod = TimeHelper::getDateRangeCondition($startDate, $endDate);
    } else {
        $wherePeriod = TimeHelper::getTimePeriod($years ?? 1);
    }

    // ==========================
    // Repository
    // ==========================
    $repo = new OceanDataRepository();

    // Statistiques de la métrique
    $stats = $repo->getMetricStats($metric, $wherePeriod);

    // Évolution temporelle de la métrique
    $evolution = $repo->getMetricEvolution($metric, $wherePeriod);

    // Comptage des mesures
    $nbMesures = $repo->countMeasures($wherePeriod);

    // ==========================
    // Réponse JSON
    // ==========================
    echo json_encode([
        'periode_ans' => $years,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'metric' => $metric,
        'nb_mesures' => $nbMesures,
        'stats' => [
            'avg_value' => $stats['avg_value'] ?? null,
            'min_value' => $stats['min_value'] ?? null,
            'max_value' => $stats['max_value'] ?? null,
            'count_measures' => $stats['count_measures'] ?? 0
        ],
        'evolution' => $evolution
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    handleApiError('API Error', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], 500);
}
