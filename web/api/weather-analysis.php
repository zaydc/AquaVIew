<?php
declare(strict_types=1);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../php_error.log');

// ==========================
// Autoloader PSR-4
// ==========================
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

// ==========================
// Imports
// ==========================
use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

header('Content-Type: application/json; charset=utf-8');

try {
    // ==========================
    // Paramètres reçus
    // ==========================
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

    // Analyse par conditions météo
    $weatherAnalysis = $repo->getWeatherAnalysis($metric, $wherePeriod);

    // ==========================
    // Réponse JSON
    // ==========================
    echo json_encode([
        'periode_ans' => $years,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'metric' => $metric,
        'weather_analysis' => $weatherAnalysis
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal Server Error', 
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
