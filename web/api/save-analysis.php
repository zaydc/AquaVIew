<?php
session_start();
require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
require_once __DIR__ . '/../../src/Config/Conf.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

// Vérifier la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Données invalides']);
    exit;
}

// Valider les données requises
$requiredFields = ['metric', 'start_date', 'end_date', 'avg_value', 'min_value', 'max_value', 'count_measures'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || $data[$field] === '') {
        http_response_code(400);
        echo json_encode(['error' => "Champ '$field' manquant"]);
        exit;
    }
}

use App\Model\Repository\UserAnalysisRepository;

try {
    $repo = new UserAnalysisRepository();
    
    // Sauvegarder l'analyse
    $analysisId = $repo->create([
        'user_id' => $_SESSION['user']['id'],
        'metric' => $data['metric'],
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'],
        'avg_value' => $data['avg_value'],
        'min_value' => $data['min_value'],
        'max_value' => $data['max_value'],
        'count_measures' => $data['count_measures'],
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Analyse sauvegardée avec succès',
        'analysis_id' => $analysisId
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erreur lors de la sauvegarde: ' . $e->getMessage()
    ]);
}
?>
