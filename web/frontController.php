<?php
/**
 * Front Controller principal - Point d'entree unique de l'application
 * BUT2 - S3 - AquaView Project
 * Gere le routage et l'initialisation de toute l'application
 */

// Demarrage de la session pour l'authentification
session_start();

// Chargement de l'autoloader PSR-4 pour le chargement auto des classes
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// Configuration et enregistrement de l'autoloader
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../src');

// Import des classes necessaires
use App\Config\Conf;
use App\Controller\ControllerUtilisateur;
use App\Lib\GeoHelper;
use App\Lib\TimeHelper;
use App\Lib\MetricHelper;

// Recuperation des parametres d'URL pour le routage
$action = $_GET['action'] ?? 'home';
$controller = $_GET['controller'] ?? 'main';

// Systeme de routage principal
try {
    switch ($controller) {
        // Route vers le controleur utilisateur
        case 'utilisateur':
            $ctrl = new ControllerUtilisateur();
            break;
        default:
            // Routes par defaut pour les pages principales
            switch ($action) {
                case '':
                case 'home':
                    // Page d'accueil principale
                    require_once __DIR__ . '/../src/View/home/home.php';
                    break;
                case 'login':
                    // Page de connexion
                    require_once __DIR__ . '/../src/View/home/login.php';
                    break;
                case 'register':
                    // Page d'inscription
                    require_once __DIR__ . '/../src/View/home/register.php';
                    break;
                case 'analyse':
                    // Page d'analyse avec donnees dynamiques
                    // Regions oceaniques definies dynamiquement depuis GeoHelper
                    $regions = array_keys(GeoHelper::getRegions());
                    // Periodes disponibles definies dynamiquement depuis TimeHelper
                    $periods = TimeHelper::getAvailablePeriods();
                    // Metriques disponibles definies dynamiquement depuis MetricHelper
                    $metrics = MetricHelper::getAvailableMetrics();

                    require_once __DIR__ . '/../src/View/home/analyse.php';
                    break;
                case 'equipe':
                    // Page de presentation de l'equipe
                    require_once __DIR__ . '/../src/View/home/equipe.php';
                    break;
                case 'logout':
                    session_destroy();
                    header('Location: /');
                    exit;
                default:
                    require_once __DIR__ . '/../src/View/home/error.php';
            }
    }
} catch (Exception $e) {
    // Gestion des erreurs globales
    error_log($e->getMessage());
    require_once __DIR__ . '/../src/View/home/error.php';
}
