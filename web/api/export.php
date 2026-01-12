<?php
declare(strict_types=1);

/**
 * API d'export des donnees oceaniques
 * BUT2 - S3 - AquaView Project
 * Endpoint qui gere les exports dans differents formats
 */

// ==========================
// Gestionnaire d'erreurs
// ==========================
error_reporting(E_ALL);
ini_set('display_errors', '0'); // En production, ne pas afficher les erreurs

// ==========================
// Autoloader PSR-4
// ==========================
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

// ==========================
// Gestionnaire d'erreurs centralise pour l'API
// ==========================
function handleApiError(string $message, array $details = [], int $statusCode = 500) {
    http_response_code($statusCode);
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
use App\Controller\ExportController;

try {
    // Validation du format
    $allowedFormats = ['json', 'csv', 'netcdf', 'png'];
    $format = $_GET['format'] ?? 'json';
    
    if (!in_array(strtolower($format), $allowedFormats)) {
        handleApiError('Format non supporté', [
            'format_demande' => $format,
            'formats_disponibles' => $allowedFormats
        ], 400);
    }
    
    // Validation de la métrique
    $allowedMetrics = ['dissoxygen', 'temperature', 'salinity', 'ph'];
    $metric = $_GET['metric'] ?? 'dissoxygen';
    
    if (!in_array(strtolower($metric), $allowedMetrics)) {
        handleApiError('Métrique non supportée', [
            'metric_demande' => $metric,
            'metriques_disponibles' => $allowedMetrics
        ], 400);
    }
    
    // Création et exécution du contrôleur d'exportation
    $controller = new ExportController();
    $controller->export();
    
} catch (Exception $e) {
    handleApiError('Export Error', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], 500);
}
