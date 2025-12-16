<?php
header("Access-Control-Allow-Origin: http://localhost:5174");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';
require_once '../models/User.php';

$data = json_decode(file_get_contents("php://input"), true);

$nom = $data['nom'] ?? '';
$prenom = $data['prenom'] ?? '';
$email = $data['email'] ?? '';
$numero = $data['numero'] ?? '';
$password = $data['password'] ?? '';

if (empty($nom) || empty($prenom) || empty($email) || empty($numero) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Tous les champs sont requis."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Email invalide."]);
    exit;
}

if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
    echo json_encode(["success" => false, "message" => "Mot de passe invalide."]);
    exit;
}

$user = new User($pdo);

if ($user->emailExists($email)) {
    echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé."]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

if ($user->create($nom, $prenom, $email, $numero, $hash)) {
    echo json_encode(["success" => true, "message" => "Compte créé avec succès !"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de la création du compte."]);
}
