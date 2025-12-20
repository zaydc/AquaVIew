<?php
declare(strict_types=1);

// ==========================
// Autoloader PSR-4
// ==========================
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

header('Content-Type: application/json; charset=utf-8');

use App\Model\Repository\OceanDataRepository;

try {
    $repo = new OceanDataRepository();
    $dateRange = $repo->getDateRange();
    
    echo json_encode([
        'min_date' => $dateRange['min_date'],
        'max_date' => $dateRange['max_date']
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur lors de la récupération des dates',
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
