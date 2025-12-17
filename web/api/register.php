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
    
    // Validation
    if (!isset($data['email']) || !isset($data['password']) || !isset($data['nom']) || !isset($data['prenom'])) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
        exit;
    }
    
    $email = trim($data['email']);
    $password = $data['password'];
    $nom = trim($data['nom']);
    $prenom = trim($data['prenom']);
    $numero = trim($data['numero'] ?? '');
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Format d\'email invalide']);
        exit;
    }
    
    // Validate password strength
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 8 caractères']);
        exit;
    }
    
    $repo = new UtilisateurRepository();
    
    // Check if email already exists
    if ($repo->emailExists($email)) {
        echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
        exit;
    }
    
    $userData = [
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'numero' => $numero,
        'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    $repo->create($userData);
    
    echo json_encode([
        'success' => true,
        'message' => 'Compte créé avec succès ! Redirection vers la connexion...'
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
}
