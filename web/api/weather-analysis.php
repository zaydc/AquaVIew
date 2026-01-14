<?php
/**
 * API pour les donnees meteo oceaniques
 * BUT2 - S3 - AquaView Project
 */

// Autoloader
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

use App\Model\Repository\OceanDataRepository;
use App\Lib\TimeHelper;

header('Content-Type: application/json');

// Parametres
$metric = $_GET['metric'] ?? 'dissoxygen';
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;
$years = isset($_GET['periode']) ? (int)$_GET['periode'] : null;

// Filtres temporels
if ($startDate || $endDate) {
    $wherePeriod = TimeHelper::getDateRangeCondition($startDate, $endDate);
} else {
    $wherePeriod = TimeHelper::getTimePeriod($years ?? 1);
}

// Repository et requetes
$repo = new OceanDataRepository();
$weatherAnalysis = $repo->getWeatherAnalysis($metric, $wherePeriod);

// Réponse JSON
echo json_encode([
    'periode_ans' => $years,
    'start_date' => $startDate,
    'end_date' => $endDate,
    'metric' => $metric,
    'weather_analysis' => $weatherAnalysis
]);
