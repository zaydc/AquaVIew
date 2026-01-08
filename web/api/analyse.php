<?php
declare(strict_types=1);

// ==========================
// Error handling
// ==========================
error_reporting(E_ALL);
ini_set('display_errors', '0');

// ==========================
// Autoloader PSR-4
// ==========================
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

header('Content-Type: application/json; charset=utf-8');

// ==========================
// Error handler
// ==========================
function handleApiError(string $message, array $details = [], int $statusCode = 500) {
    http_response_code($statusCode);
    echo json_encode([
        'error' => $message,
        'details' => $details,
        'timestamp' => date('c')
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
