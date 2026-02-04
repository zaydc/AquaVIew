<?php
/**
 * API d'analyse des donnees oceaniques
 * BUT2 - S3 - AquaView Project
 */

// Autoloader
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

header('Content-Type: application/json');

use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

// Activer le rapport d'erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 0); // Cacher les erreurs HTML mais les logger

try {
    // Paramètres
    $metric = $_GET['metric'] ?? 'dissoxygen';
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;
    $years = isset($_GET['periode']) ? (int)$_GET['periode'] : null;

    // Filtres
    if ($startDate || $endDate) {
        $wherePeriod = TimeHelper::getDateRangeCondition($startDate, $endDate);
    } else {
        $wherePeriod = TimeHelper::getTimePeriod($years ?? 1);
    }

    // Repository
    $repo = new OceanDataRepository();
    
    // Récupérer les données avec gestion d'erreurs
    $stats = $repo->getMetricStats($metric, $wherePeriod);
    $evolution = $repo->getMetricEvolution($metric, $wherePeriod);
    $nbMesures = $repo->countMeasures($wherePeriod);
    $weatherAnalysis = $repo->getWeatherAnalysis($metric, $wherePeriod);

    // Réponse JSON
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
        'evolution' => $evolution,
        'weather_analysis' => $weatherAnalysis
    ]);

} catch (Exception $e) {
    // En cas d'erreur, retourner une réponse JSON d'erreur
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
} catch (Error $e) {
    // Pour les erreurs fatales PHP 7+
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
