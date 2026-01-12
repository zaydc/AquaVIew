<?php
namespace App\Controller;

use App\Model\Repository\UtilisateurRepository;
use App\Model\Repository\UserAnalysisRepository;

class ControllerUtilisateur {
    private UtilisateurRepository $repository;
    private UserAnalysisRepository $analysisRepository;

    public function __construct() {
        $this->repository = new UtilisateurRepository();
        $this->analysisRepository = new UserAnalysisRepository();
        $this->handleAction();
    }

    private function handleAction(): void {
        $action = $_GET['action'] ?? 'list';
        
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'doLogin':
                $this->doLogin();
                break;
            case 'register':
                $this->register();
                break;
            case 'doRegister':
                $this->doRegister();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'list':
                $this->list();
                break;
            case 'detail':
                $this->detail();
                break;
            case 'create':
                $this->create();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'profile':
                $this->profile();
                break;
            case 'doUpdateProfile':
                $this->doUpdateProfile();
                break;
            case 'doDeleteAccount':
                $this->doDeleteAccount();
                break;
            case 'downloads':
                $this->downloads();
                break;
            default:
                $this->list();
        }
    }

    private function login(): void {
        require_once __DIR__ . '/../View/utilisateur/login.php';
    }

    private function doLogin(): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email et mot de passe requis.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $user = $this->repository->findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom']
        ];

        header('Location: /');
        exit;
    }

    private function register(): void {
        require_once __DIR__ . '/../View/utilisateur/register.php';
    }

    private function doRegister(): void {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $numero = $_POST['numero'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($nom) || empty($prenom) || empty($email) || empty($numero) || empty($password)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $_SESSION['error'] = 'Mot de passe invalide (min 8 car., 1 Maj, 1 Chiffre).';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        if ($this->repository->emailExists($email)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            header('Location: ?controller=utilisateur&action=register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($this->repository->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numero' => $numero,
            'mot_de_passe' => $hash
        ])) {
            $_SESSION['success'] = 'Compte créé avec succès !';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $_SESSION['error'] = 'Erreur lors de la création du compte.';
        header('Location: ?controller=utilisateur&action=register');
        exit;
    }

    private function logout(): void {
        session_destroy();
        header('Location: /');
        exit;
    }

    private function list(): void {
        $utilisateurs = $this->repository->findAll();
        require_once __DIR__ . '/../View/utilisateur/list.php';
    }

    private function detail(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $utilisateur = $this->repository->findById($id);
        
        if (!$utilisateur) {
            $_SESSION['error'] = 'Utilisateur non trouvé.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        require_once __DIR__ . '/../View/utilisateur/detail.php';
    }

    private function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->repository->create([
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero'],
                'mot_de_passe' => $hash
            ]);
            $_SESSION['success'] = 'Utilisateur créé avec succès.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        require_once __DIR__ . '/../View/utilisateur/create.php';
    }

    private function update(): void {
        $id = (int) ($_GET['id'] ?? 0);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->repository->update($id, [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'numero' => $_POST['numero']
            ]);
            $_SESSION['success'] = 'Utilisateur mis à jour.';
            header('Location: ?controller=utilisateur&action=list');
            exit;
        }
        
        $utilisateur = $this->repository->findById($id);
        require_once __DIR__ . '/../View/utilisateur/update.php';
    }

    private function delete(): void {
        $id = (int) ($_GET['id'] ?? 0);
        $this->repository->delete($id);
        $_SESSION['success'] = 'Utilisateur supprimé.';
        header('Location: ?controller=utilisateur&action=list');
        exit;
    }

    private function profile(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }
        
        $userId = $_SESSION['user']['id'];
        $utilisateur = $this->repository->findById($userId);
        
        // Récupérer les dernières analyses de l'utilisateur
        $recentAnalyses = $this->analysisRepository->findByUserId($userId, 5);
        $userStats = $this->analysisRepository->getUserStats($userId);
        
        // Récupérer les derniers téléchargements (simulés pour l'instant)
        $recentDownloads = $this->getUserDownloads($userId);
        
        require_once __DIR__ . '/../View/utilisateur/profile.php';
    }

    private function doUpdateProfile(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $numero = $_POST['numero'] ?? '';

        if (empty($nom) || empty($prenom) || empty($email) || empty($numero)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        if ($this->repository->emailExists($email) && $email !== $_SESSION['user']['email']) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        if ($this->repository->update($userId, [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numero' => $numero
        ])) {
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['email'] = $email;
            $_SESSION['success'] = 'Profil mis à jour avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de la mise à jour du profil.';
        }

        header('Location: ?controller=utilisateur&action=profile');
        exit;
    }

    private function doDeleteAccount(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }

        $password = $_POST['password'] ?? '';
        $userId = $_SESSION['user']['id'];

        if (empty($password)) {
            $_SESSION['error'] = 'Le mot de passe est requis pour supprimer votre compte.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        $utilisateur = $this->repository->findById($userId);
        
        if (!$utilisateur || !password_verify($password, $utilisateur['mot_de_passe'])) {
            $_SESSION['error'] = 'Mot de passe incorrect. La suppression du compte a été annulée.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }

        if ($this->repository->delete($userId)) {
            session_destroy();
            $_SESSION['success'] = 'Votre compte a été supprimé avec succès.';
            header('Location: ?controller=utilisateur&action=login');
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression du compte.';
            header('Location: ?controller=utilisateur&action=profile');
            exit;
        }
    }

    private function downloads(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=utilisateur&action=login');
            exit;
        }
        
        $userId = $_SESSION['user']['id'];
        $utilisateur = $this->repository->findById($userId);
        $allDownloads = $this->getUserDownloads($userId, 50); // Plus de téléchargements pour cette page
        
        require_once __DIR__ . '/../View/utilisateur/downloads.php';
    }

    private function getUserDownloads(int $userId, int $limit = 5): array {
        // Simuler des données de téléchargements pour l'instant
        // Dans un vrai projet, cela viendrait d'une base de données
        $downloads = [];
        $formats = ['csv', 'json', 'pdf'];
        $metrics = ['Oxygène dissous', 'Température', 'Salinité', 'pH'];
        
        for ($i = 0; $i < min($limit, 12); $i++) {
            $date = date('Y-m-d H:i:s', strtotime("-{$i} days"));
            $format = $formats[array_rand($formats)];
            $metric = $metrics[array_rand($metrics)];
            $fileSize = rand(1000, 50000); // Taille en octets
            
            $downloads[] = [
                'id' => $i + 1,
                'metric' => $metric,
                'format' => $format,
                'file_size' => $fileSize,
                'record_count' => rand(50, 500),
                'date_range' => date('d/m/Y', strtotime("-{$i} days")) . ' - ' . date('d/m/Y'),
                'created_at' => $date,
                'file_path' => "#download-{$i}" // Simuler un chemin de fichier
            ];
        }
        
        return $downloads;
    }
}
