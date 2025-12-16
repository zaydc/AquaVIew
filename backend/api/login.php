<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
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

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Email et mot de passe requis."
    ]);
    exit;
}

$user = new User($pdo);
$userData = $user->findByEmail($email);

if (!$userData) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect."
    ]);
    exit;
}

if (!password_verify($password, $userData['mot_de_passe'])) {
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect."
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Connexion réussie",
    "user" => [
        "id" => $userData['id'],
        "email" => $userData['email'],
        "nom" => $userData['nom'],
        "prenom" => $userData['prenom']
    ]
]);
