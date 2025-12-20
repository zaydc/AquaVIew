<?php
session_start();

// Autoloader PSR-4
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../src');

use App\Config\Conf;
use App\Controller\ControllerUtilisateur;
use App\Lib\GeoHelper;
use App\Lib\TimeHelper;
use App\Lib\MetricHelper;

// Get action from URL
$action = $_GET['action'] ?? 'home';
$controller = $_GET['controller'] ?? 'main';

// Route handling
try {
    switch ($controller) {
        case 'utilisateur':
            $ctrl = new ControllerUtilisateur();
            break;
        default:
            switch ($action) {
                case '':
                case 'home':
                    require_once __DIR__ . '/../src/View/home/home.php';
                    break;
                case 'login':
                    require_once __DIR__ . '/../src/View/home/login.php';
                    break;
                case 'register':
                    require_once __DIR__ . '/../src/View/home/register.php';
                    break;
                case 'analyse':
                    // Régions océaniques définies dynamiquement
                    $regions = array_keys(GeoHelper::getRegions());
                    // Périodes disponibles définies dynamiquement
                    $periods = TimeHelper::getAvailablePeriods();
                    // Métriques disponibles définies dynamiquement
                    $metrics = MetricHelper::getAvailableMetrics();

                    require_once __DIR__ . '/../src/View/home/analyse.php';
                    break;
                case 'equipe':
                    require_once __DIR__ . '/../src/View/home/equipe.php';
                    break;
                case 'ensavoirplus':
                    require_once __DIR__ . '/../src/View/home/ensavoirplus.php';
                    break;
                case 'logout':
                    session_destroy();
                    header('Location: ?action=home');
                    exit;
                default:
                    require_once __DIR__ . '/../src/View/home/error.php';
            }
    }
} catch (Exception $e) {
    require_once __DIR__ . '/../src/View/home/error.php';
}
