<?php
/**
 * API pour recuperer l'intervalle de dates disponibles
 * BUT2 - S3 - AquaView Project
 */

// Autoloader
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

header('Content-Type: application/json');

use App\Model\Repository\OceanDataRepository;

$repo = new OceanDataRepository();
$dateRange = $repo->getDateRange();

echo json_encode([
    'min_date' => $dateRange['min_date'],
    'max_date' => $dateRange['max_date']
]);
