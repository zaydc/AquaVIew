@ -1,72 +0,0 @@
<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('App', __DIR__ . '/../../src');

use App\Model\Repository\UtilisateurRepository;

$data = json_decode(file_get_contents('php://input'), true);

// Validation
if (!isset($data['email']) || !isset($data['password']) || !isset($data['nom']) || !isset($data['prenom'])) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];
$nom = $data['nom'];
$prenom = $data['prenom'];
$numero = trim($data['numero'] ?? '');

// Validation email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email invalide']);
    exit;
}

// Validation mot de passe
if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Mot de passe invalide (min 8 car., 1 Maj, 1 Chiffre)']);
    exit;
}

$repo = new UtilisateurRepository();

// Verification email existe deja
if ($repo->emailExists($email)) {
    echo json_encode(['success' => false, 'message' => 'Cet email est deja utilise']);
    exit;
}

// Hashage du mot de passe
$hash = password_hash($password, PASSWORD_DEFAULT);

// Creation utilisateur
if ($repo->create([
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'numero' => $numero,
    'mot_de_passe' => $hash
])) {
    echo json_encode(['success' => true, 'message' => 'Compte cree avec succes']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Erreur lors de la creation du compte']);