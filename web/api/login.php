<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

use App\Model\Repository\UtilisateurRepository;

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['email']) || !isset($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
        exit;
    }
    
    $email = trim($data['email']);
    $password = $data['password'];
    
    $repo = new UtilisateurRepository();
    $user = $repo->findByEmail($email);
    
    if (!$user || !password_verify($password, $user['mot_de_passe'])) {
        echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        exit;
    }
    
    // Creation de la session utilisateur
    $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom']
    ];
    
    echo json_encode([
        'success' => true,
        'message' => 'Connexion reussie',
        'user' => $_SESSION['user']
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la connexion: ' . $e->getMessage()]);
}
