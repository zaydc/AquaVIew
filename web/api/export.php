<?php
/**
 * API d'export des donnees oceaniques
 * BUT2 - S3 - AquaView Project
 */

// Autoloader
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

use App\Controller\ExportController;

// Validation du format
$allowedFormats = ['json', 'csv', 'netcdf'];
$format = $_GET['format'] ?? 'json';

if (!in_array(strtolower($format), $allowedFormats)) {
    die(json_encode(['error' => 'Format non supporté']));
}

// Validation de la métrique
$allowedMetrics = ['dissoxygen', 'temperature', 'salinity', 'ph'];
$metric = $_GET['metric'] ?? 'dissoxygen';

if (!in_array(strtolower($metric), $allowedMetrics)) {
    die(json_encode(['error' => 'Métrique non supportée']));
}

// Création et exécution du contrôleur d'exportation
$controller = new ExportController();
$controller->export();
